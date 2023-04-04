<?php
session_start();
require "functions.php";

if( count($_POST) != 7
	|| empty($_POST["firstname"])
	|| empty($_POST["lastname"])
	|| empty($_POST["email"])
	|| !isset($_POST["country"])
	|| empty($_POST["tel"])
	|| empty($_POST["pwd"])
	|| empty($_POST["pwdConfirm"])) 
{
	print_r($_POST);
    die("Faire quelque chose de un minimum graphique");
}

$_POST["lastname"] = cleanLastname($_POST["lastname"]);
$_POST["firstname"] = cleanFirstname($_POST["firstname"]);
$_POST["email"] = cleanEmail($_POST["email"]);


$listOfErrors = [];

if(strlen($_POST["lastname"]) < 2){
	$listOfErrors[] = ["lastname", "Le nom doit faire plus de 2 caractères"];
}
if(strlen($_POST["firstname"]) < 2){
	$listOfErrors[] = ["firstname", "Le prénom doit faire plus de 2 caractères"];
}

$listOfCities = [0,1];
if(!in_array($_POST['country'], $listOfCities) ){
	$listOfErrors[] = ["country", "L'extension téléphone n'est pas valide"];
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	$listOfErrors[] = ["email", "L'email est incorrect"];
}
// Email -> Unicité

//Adapter à tous les numéros de téléphone du monde
if(!preg_match("#^0?[1-9]([ -]?[0-9]{2}){4}$#", $_POST["tel"])){
    $listOfErrors[] = ["tel", "Numéro de téléphone invalide"];
}

// Pwd -> Min 8 caractères avec minuscules majuscules et chiffres
if( strlen($_POST["pwd"])<8
    || !preg_match("#[a-z]#", $_POST["pwd"])
	|| !preg_match("#[A-Z]#", $_POST["pwd"])
	|| !preg_match("#[?!._&]#", $_POST["pwd"])
	|| !preg_match("#[0-9]#", $_POST["pwd"]))
{
    $listOfErrors[] = ["pwd", "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules, des chiifres et des caractères spéciaux (?!._&)"];
}


//pwdConfirm -> = Pwd
if($_POST["pwd"] != $_POST["pwdConfirm"]){
	$listOfErrors[] = ["pwdConfirm", "Votre mot de passe de confirmation ne correspond pas"];
}


if(empty($listOfErrors)){
    $validateCode = "";
    for($cpt = 0; $cpt < 6; $cpt++){
        $validateCode .= strval(rand(0, 9));
    }
    $_POST['validateCode'] = $validateCode;
    $_POST["pwd"] = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $_SESSION['form1'] = $_POST;
    header("Location: ../pages/emailConfirm.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../pages/register1.php");
}
