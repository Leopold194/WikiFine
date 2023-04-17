<?php
session_start();
require "functions.php";

if(!isset($_POST["cgu"]))
{
    die("Faire quelque chose de un minimum graphique");
}

$listOfErrors = [];

if(!array_key_exists('interest', $_POST) || count($_POST['interest']) < 3){
    $listOfErrors[] = "Vous devez selectionnez au moins 3 centres d'intérêt dans la liste";
}

echo phpinfo();

if(empty($listOfErrors)){
    //$_SESSION['form2'] = $_POST;
	$_SESSION['login'] = 4;
    $connection = connectDB();
    echo 'oui';
    $query=$connection->prepare("INSERT INTO WF_USER (pseudo, firstname, lastname, email, password, newsletter, birthday, gender, address, city, country, post_code, phone, phone_ext, avatar) VALUES (:pseudo, :firstname, :lastname, :email, :password, :newsletter, :birthday, :gender, :address, :city, :country, :post_code, :phone, :phone_ext, :avatar)");
    $query->execute([
        "pseudo"=>$_SESSION['form2']['pseudo'], 
        "firstname"=>$_SESSION['form1']['firstname'], 
        "lastname"=>$_SESSION['form1']['lastname'], 
        "email"=>$_SESSION['form1']['email'], 
        "password"=>$_SESSION['form1']['pwd'], 
        "newsletter"=>$_FORM['firstname'], 
        "birthday"=>$_SESSION['form2']['birthday'], 
        "gender"=>$_SESSION['form2']['gender'], 
        "address"=>$_SESSION['form2']['adress'], 
        "city"=>$_SESSION['form2']['city'], 
        "country"=>$_SESSION['form2']['country'], 
        "post_code"=>$_SESSION['form2']['cp'], 
        "phone"=>$_SESSION['form1']['tel'], 
        "phone_ext"=>$_SESSION['form1']['country'], 
        //"avatar"=>$_SESSION['form1']['firstname'],
    ]);
    //header("Location: ../pages/login.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../pages/register3.php");
}

?>