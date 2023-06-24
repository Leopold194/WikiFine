<?php
    session_start();
    require '../functions.php';
    require '../../conf.inc.php';
    require '../vendor/autoload.php';

    use Aws\S3\S3Client;
    
    $data = file_get_contents('../../../secrets/secrets.json');
    $obj = json_decode($data);

    $region = 'eu-west-2';
    $version = 'latest';
    $access_key_id = $obj[0]->KEY_ID;
    $secret_access_key = $obj[0]->SECRET_KEY;
    $bucket = 'wikifine';

    $statusMsg = '';
    $status = 'danger';
    $_SESSION['articleData'] = $_POST;

    $listOfErrors = [];

    $connection = connectDB();
    $query = $connection->query('SELECT title FROM '.DB_PREFIX.'ARTICLE WHERE LOWER(title)="'.strtolower($_POST['title']).'"');
    $result = $query->fetch();

    if(!empty($result)) {
        $listOfErrors[] = ["title", "Un article possède déjà ce titre"];
    } 

    if(empty($_POST['title'])) {
        $listOfErrors[] = ["title", "Vous devez renseigner un titre à votre article"];
    }

    if(strlen($_POST["title"]) > 50){
        $listOfErrors[] = ["title", "Le titre de votre article fait plus de 50 caractères"];
    }

    if(empty($_POST['content'])) {
        $listOfErrors[] = ['content', 'Vous devez écrire un contenu à votre article'];
    }

    if(empty($_FILES['poster']['name'])) {
        $listOfErrors[] = ['poster', 'Vous devez fournir une image de couverture à votre article'];
    }

    if(!empty($listOfErrors)) {
        $_SESSION['errors'] = $listOfErrors;
        header("Location: ../../pages/articles/write_article.php");
    }else{
        
        unset($_SESSION['articleData']);

        $result = getData(Array('id'), $_SESSION['id']);

        $pattern0 = '/base64,([^\'"]+)/';
        $pattern1 = '/image\/([^;]+)/';
        preg_match_all($pattern0, $_POST['content'], $matches0);
        preg_match_all($pattern1, $_POST['content'], $matches1);

        $s3 = new S3Client([
            'version' => $version,
            'region' => $region,
            'credentials' => [
                'key' => $access_key_id,
                'secret' => $secret_access_key
            ]
        ]);

        $file_name = basename($_FILES["poster"]["name"]);
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

        $allowTypes = Array('jpg', 'png', 'jpeg');

        if(in_array($file_type, $allowTypes)) {
            $file_temp_src = $_FILES['poster']['tmp_name'];
    
            if(is_uploaded_file($file_temp_src)) {

                try { 
                    $result = $s3->putObject([ 
                        'Bucket' => $bucket, 
                        'Key'    => time()."_".uniqid().".".$file_type, 
                        'Body' => $file_temp_src
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
            }
        }

        $poster = $s3_file_link;

        for($cpt = 0; $cpt < count($matches0[1]); $cpt++) {
            $binaryImage = base64_decode($matches0[1][$cpt]);
            $filename = time()."_".uniqid().".".$matches1[1][$cpt];

            $allowTypes = Array('jpg', 'png', 'jpeg', 'gif');

            if(in_array($matches1[1][$cpt], $allowTypes)) {

                try { 
                    $result = $s3->putObject([ 
                        'Bucket' => $bucket, 
                        'Key'    => $filename, 
                        'Body' => $binaryImage,
                        'ContentType' => $matches1[0][$cpt]
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
            }

            $_POST['content'] = str_replace('data:'.$matches1[0][$cpt].';'.$matches0[0][$cpt], $s3_file_link, $_POST['content']);
        }

        if(empty($api_error)){ 
            $status = 'success'; 
            $statusMsg = "File was uploaded to the S3 bucket successfully!"; 
            
            $connect = connectDB();
            $query=$connect->prepare("INSERT INTO ".DB_PREFIX."ARTICLE (title, content, img, author) VALUES (:title, :content, :img, :author)");
            $query->execute([
                "title"=>$_POST['title'],
                "content"=>$_POST['content'],
                "img"=>$poster,
                "author"=>$result[0]
            ]);
        }

        $connect = connectDB();
        $query=$connect->query('SELECT id FROM '.DB_PREFIX.'ARTICLE WHERE LOWER(title)="'.strtolower($_POST["title"]).'"');
        $id = $query->fetch();

        /*header("Location: ../../pages/articles/articles.php?id=".$id['id']);*/
    }
?>