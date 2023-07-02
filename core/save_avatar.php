<?php
    session_start();
    require 'functions.php';
    require '../conf.inc.php';
    require 'vendor/autoload.php';

    use Aws\S3\S3Client;

    // Vérification des données envoyées 
    if(count($_POST) != 1 || empty($_POST['svgAvatar'])) {
        die("Erreur lors de la réception de l'avatar.");
    }

    // Enregistrez les données de l'avatar dans la session
    $_SESSION['avatar_data'] = $_POST['svgAvatar'];

    $data = file_get_contents('../../secrets/secrets.json');
    $obj = json_decode($data);

    $region = 'eu-west-2';
    $version = 'latest';
    $access_key_id = $obj[0]->KEY_ID;
    $secret_access_key = $obj[0]->SECRET_KEY;
    $bucket = 'wikifine';

    $statusMsg = '';
    $status = 'danger';

    // Récupération du SVG
    $svg = $_SESSION['avatar_data'];

    // Connexion à S3
    $s3 = new S3Client([
        'version' => $version,
        'region' => $region,
        'credentials' => [
            'key' => $access_key_id,
            'secret' => $secret_access_key
        ]
    ]);

    // Nom du fichier unique pour le nouvel avatar
    $fileName = uniqid('avatar_') . '.svg';

    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $fileName,
            'Body' => $svg,
            'ContentType' => 'image/svg+xml'
        ]);

        $result_arr = $result->toArray();

        if (!empty($result_arr['ObjectURL'])) {
            $s3_file_link = $result_arr['ObjectURL'];

            $connect = connectDB();
            $queryPrepared = $connect->prepare("UPDATE " . DB_PREFIX . "USER SET avatar = :avatar WHERE id = :id");
            $queryPrepared->execute([
                "avatar" => $s3_file_link,
                "id" => $_SESSION['user_id']
            ]);

            $status = 'success';
            $statusMsg = "Avatar mis à jour avec succès !";
        } else {
            $statusMsg = 'Upload Failed! S3 Object URL not found.';
        }

    } catch (Aws\S3\Exception\S3Exception $e) {
        $statusMsg = $e->getMessage();
    }

    // Redirigez l'utilisateur vers la page suivante de l'inscription
    header("Location: ..pages/register_login/register.php?status=$status&message=$statusMsg");
?>
