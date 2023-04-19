<?php
session_start();
require "../functions.php";
require "../../conf.inc.php";

if(!isset($_POST["cgu"]))
{
    die("Faire quelque chose de un minimum graphique");
}

$listOfErrors = [];

if(!array_key_exists('interest', $_POST) || count($_POST['interest']) < 3){
    $listOfErrors[] = "Vous devez selectionnez au moins 3 centres d'intérêt dans la liste";
}

$_POST['newsletter'] = ($_POST['newsletter'] == 'on') ? (1) : (0);

if(empty($listOfErrors)){
    $connection = connectDB();
    $query=$connection->prepare("INSERT INTO ".DB_PREFIX."USER (pseudo, firstname, lastname, email, password, newsletter, birthday, gender, address, city, country, post_code, phone, phone_ext) VALUES (:pseudo, :firstname, :lastname, :email, :password, :newsletter, :birthday, :gender, :address, :city, :country, :post_code, :phone, :phone_ext)");
    $query->execute([
        "pseudo"=>$_SESSION['form2']['pseudo'], 
        "firstname"=>strtolower($_SESSION['form1']['firstname']), 
        "lastname"=>strtolower($_SESSION['form1']['lastname']), 
        "email"=>$_SESSION['form1']['email'], 
        "password"=>$_SESSION['form1']['pwd'], 
        "newsletter"=>$_POST['newsletter'], 
        "birthday"=>$_SESSION['form2']['birthday'], 
        "gender"=>$_SESSION['form2']['gender'], 
        "address"=>$_SESSION['form2']['adress'], 
        "city"=>$_SESSION['form2']['city'], 
        "country"=>$_SESSION['form2']['country'], 
        "post_code"=>$_SESSION['form2']['cp'], 
        "phone"=>$_SESSION['form1']['tel'], 
        "phone_ext"=>$_SESSION['form1']['country'], 
        //"avatar"=>
    ]);
    unset($_SESSION['register']);
    header("Location: ../../pages/register_login/login.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../../pages/register_login/register3.php");
}

?>