<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require "../functions.php";
require "../../conf.inc.php";

if(count($_POST) != 1 || empty($_POST["id"])) {
    die("Faire quelque chose de un minimum graphique");
}

if(!checkDataInDB("email", $_POST['id']) && !checkDataInDB("pseudo", $_POST['id'])) {
    $listOfErrors[] = ["id", "Vous n'avez pas de compte"];
}

if(empty($listOfErrors)){
    
    $connection = connectDB();
    $queryPrepared = $connection->prepare("SELECT email, pseudo FROM ".DB_PREFIX."USER WHERE (email=:email OR pseudo=:pseudo)");
    $queryPrepared->execute([
        "email"=>$_POST['id'],
        "pseudo"=>$_POST['id']
    ]);
    $result = $queryPrepared->fetch();

    $listOfChars = "abcdefghijklmnopqrstuvwxyzABCDEFHIJKLMNOPQRSTUVWXYZ0123456789?!._&";
    $listOfChars  = str_shuffle($listOfChars);
    $tempPwd = substr($listOfChars, 0, rand(8, 10));

    $connect = connectDB();
    $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET password=:pwd WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$result['email'],
        "pwd"=>password_hash($tempPwd, PASSWORD_DEFAULT)
    ]);

    sendMail(
        $result['email'], 
        "Réinitialisation de votre mot de passe", 
        '<center>
        <a href="www.wikifine.org"><img src="https://drive.google.com/uc?id=1NMNel1OLhMk-XW22pAGLg2ZRvIznSSNo" alt="Logo">
        </a><br><br><br><h1>Bonjour <span style="text-decoration:underline;color:#5F85DB;">'.$result['pseudo'].'</span>,</h1><br><br>
        <h4>Une demande de modification de votre mot de passe nous a été envoyée récemment.<br>Nous vous fournissons un mot de passe temporaire, que vous pourrez modifier par la suite en vous dirigeant sur le lien ci-dessous : </h4><br><span style="color:#5F85DB;">https://wikifine.org/pages/account/user.php</span><br>
        <i>Mot de passe temporaire :</i><br><br><br>
        <span style="font-size: 50px;">'.$tempPwd.'</span><br><br><br><br><br><br><br><i>Ce mail a 
        été généré automatiquement, merci de ne pas y répondre.
        </center>'
    );
    header("Location: ../../pages/register_login/login.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../../pages/register_login/reset_password.php");
}
