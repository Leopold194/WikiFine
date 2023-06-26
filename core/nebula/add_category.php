<?php

    session_start();
    require '../functions.php';
    require '../../conf.inc.php';
    require '../vendor/autoload.php';

    use Aws\S3\S3Client;

    if(count($_POST) != 2
        || empty($_FILES["logo"]["name"])
        || empty($_POST["title"])
        || empty($_POST["desc"])) 
    {
        die("Faire quelque chose de un minimum graphique");
    }

    $data = file_get_contents('../../../secrets/secrets.json');
    $obj = json_decode($data);

    $region = 'eu-west-2';
    $version = 'latest';
    $access_key_id = $obj[0]->KEY_ID;
    $secret_access_key = $obj[0]->SECRET_KEY;
    $bucket = 'wikifine';

    $statusMsg = '';
    $status = 'danger';

    $file_name = basename($_FILES["logo"]["name"]);
    $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

    $allowTypes = Array('jpg', 'png', 'jpeg');

    if(in_array($file_type, $allowTypes)) {
        $file_temp_src = $_FILES['logo']['tmp_name'];

        if(is_uploaded_file($file_temp_src)) {
            $s3 = new S3Client([
                'version' => $version,
                'region' => $region,
                'credentials' => [
                    'key' => $access_key_id,
                    'secret' => $secret_access_key
                ]
            ]);

            try { 
                $result = $s3->putObject([ 
                    'Bucket' => $bucket, 
                    'Key'    => $file_name, 
                    'SourceFile' => $file_temp_src ,
                    'ContentType' => 'image/'.$file_type
                ]); 
                $result_arr = $result->toArray(); 
                 
                if(!empty($result_arr['ObjectURL'])) { 
                    $s3_file_link = $result_arr['ObjectURL']; 
                } else { 
                    $api_error = 'Upload Failed! S3 Object URL not found.'; 
                } 
            } catch (Aws\S3\Exception\S3Exception $e) { 
                $api_error = $e->getMessage(); 
            }

            if(empty($api_error)){ 
                $status = 'success'; 
                $statusMsg = "File was uploaded to the S3 bucket successfully!"; 

                $connect = connectDB();
                $queryPrepared = $connect->prepare("INSERT INTO ".DB_PREFIX."CATEGORY (title, description, logo) VALUES (:title, :desc, :logo)");
                $queryPrepared->execute([
                    "title"=>$_POST["title"],
                    "desc"=>$_POST["desc"],
                    "logo"=>$s3_file_link
                ]);

            }else{ 
                $statusMsg = $api_error; 
            } 

        }else { 
            $statusMsg = "File upload failed!"; 
        }

    }else { 
        $statusMsg = 'Sorry, only jpg, jpeg, png files are allowed to upload.'; 
    }

    header("Location: ../../nebula/categories.php");

?>