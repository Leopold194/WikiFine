<?php
    session_start();
    require '../functions.php';
    require '../../conf.inc.php';

    if(!empty($_POST['pwd']) && !empty($_POST['id'])){
        
        $pseudo = $_POST['id'];
        $email = cleanEmail($_POST['id']);

        $connection = connectDB();
        $queryPrepared = $connection->prepare("SELECT password, email, status FROM ".DB_PREFIX."USER WHERE (email=:email OR pseudo=:pseudo)");
        $queryPrepared->execute([
            "email"=>$email,
            "pseudo"=>$pseudo
        ]);
        $result = $queryPrepared->fetch();

        if(!empty($result) && password_verify($_POST['pwd'], $result['password']) && ($result['status'] == 2 || $result['status'] == 1)){
            $_SESSION['id'] = $result["email"];
            $_SESSION['super_login'] = 1;
            $_SESSION['currentPage'] = 1;
            header('Location: ../../nebula/dashboard.php');
        }else{
            $_SESSION['errors'] = "Identifiant ou Mot de passe incorrect.";
            header("Location: ../../nebula/index.php");
        }
    }else{
        $_SESSION['errors'] = "Identifiant ou Mot de passe incorrect.";
        header("Location: ../../nebula/index.php");
    }
?>