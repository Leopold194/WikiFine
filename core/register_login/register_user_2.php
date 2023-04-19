<?php
session_start();
require "../functions.php";
require "../../conf.inc.php";


if( count($_POST) != 7
	|| empty($_POST["pseudo"])
	|| empty($_POST["birthday"])
	|| !isset($_POST["gender"])
	|| !isset($_POST["adress"])
	|| empty($_POST["country"])
	|| empty($_POST["cp"])
	|| empty($_POST["city"])) 
{
    die("Faire quelque chose de un minimum graphique");
}

$_POST['pseudo'] = trim($_POST['pseudo']);
$_POST["adress"] = trim($_POST["adress"]);
$_POST["country"] = trim($_POST["country"]);
$_POST["cp"] = trim($_POST["cp"]);
$_POST["city"] = trim($_POST["city"]);

$listOfErrors = [];

$pattern = "#^[a-z0-9-_]{3,30}$#i";
if(!preg_match($pattern, $_POST['pseudo'])) {
    $listOfErrors[] = ["pseudo", "Pseudonyme incorrect : Entre 3 et 30 caractères, pas de caractères spéciaux (à part - et _)"];
}else{
    if(checkDataInDB("pseudo", $_POST['pseudo'])) {
		$listOfErrors[] = ["pseudo", "Pseudo déjà existant"];
	}
}

$birthdaySeparate = explode("-", $_POST['birthday']);

if(!checkdate($birthdaySeparate[1], $birthdaySeparate[2], $birthdaySeparate[0])){
	$listOfErrors[] = ["birthday", "Format de date incorrect"];
}else{
	$todaySecond = time();
	$birthdaySecond = strtotime($_POST['birthday']);
	$ageSecond = $todaySecond - $birthdaySecond;
	$age = $ageSecond/60/60/24/365.25;
	if($age < 6) {
		$listOfErrors[] = ["birthday", "Vous n'avez pas l'âge requis"];
	}
}

$listOfGenders = [0,1,2];
if(!in_array($_POST['gender'], $listOfGenders) ){
	$listOfErrors[] = ["gender", "Le genre n'existe pas"];
}

$pattern = "#^[0-9]{1,4} ?,? ?[a-zA-Z0-9\s']{1,40}$#i";
if(!preg_match($pattern, $_POST['adress'])) {
    $listOfErrors[] = ["adress", "Adresse incorrect, doit être au format : 47, rue du 14 Juillet"];
}

$pattern = "#^[a-z\s]{4,40}$#i";
if(!preg_match($pattern, $_POST['country'])) {
    $listOfErrors[] = ["country", "Pays incorrect"];
}

$pattern = "#^[0-9]{5}$#i";
if(!preg_match($pattern, $_POST['cp'])) {
    $listOfErrors[] = ["cp", "Code postal invalide"];
}

if(empty($listOfErrors)){
    $_SESSION['form2'] = $_POST;
	$_SESSION['register'] = 3;
    header("Location: ../../pages/register_login/register3.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../../pages/register_login/register2.php");
}
?>