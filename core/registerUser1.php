<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

if( strlen($_POST["pwd"])<8
    || !preg_match("#[a-z]#", $_POST["pwd"])
	|| !preg_match("#[A-Z]#", $_POST["pwd"])
	|| !preg_match("#[?!._&]#", $_POST["pwd"])
	|| !preg_match("#[0-9]#", $_POST["pwd"]))
{
    $listOfErrors[] = ["pwd", "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules, des chiifres et des caractères spéciaux (?!._&)"];
}

if($_POST["pwd"] != $_POST["pwdConfirm"]){
	$listOfErrors[] = ["pwdConfirm", "Votre mot de passe de confirmation ne correspond pas"];
}

if(empty($listOfErrors)){
    $validateCode = "";
    for($cpt = 0; $cpt < 6; $cpt++){
        $validateCode .= strval(rand(0, 9));
    }

	//Load Composer's autoloader
	require 'vendor/autoload.php';
	
	$data = file_get_contents('../../secrets/secrets.json');
	$obj = json_decode($data);

	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->isSMTP();
		$mail->Host       = $obj[0]->HOST;
		$mail->SMTPAuth   = true;
		$mail->Username   = $obj[0]->USERNAME;
		$mail->Password   = $obj[0]->SMTP_PASSWORD;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port       = $obj[0]->PORT;
	
		//Recipients
		$mail->setFrom($obj[0]->USERNAME, $obj[0]->ADRESS_NAME);
		$mail->addAddress($_POST['email']);
	
		//Content
		$mail->isHTML(true);
		$mail->Subject = 'Confirmation par e-mail';
		$mail->Body    = '<center>
						<a href="www.wikifine.org"><img src="https://drive.google.com/uc?id=1NMNel1OLhMk-XW22pAGLg2ZRvIznSSNo" alt="Logo">
						</a><br><br><br><h1>Te voilà arrivé sur WikiFine !</h1><br><br><h3>Prêt à apprendre pleins de nouvelles choses, 
						et épater tout le monde en repas de famille ?</h3><br><i>Nous devons vérifier ton adresse e-mail. Pour ce faire, 
						saisi le code de confirmation suivant :</i><br><br><br><span style="font-size: 50px;">'.$validateCode.'</span><br><br><br><br><br><br><br><i>Ce mail a 
						été généré automatiquement, merci de ne pas y répondre.
						</center>';
		$mail->CharSet = 'UTF-8';   
		$mail->send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

    $_POST['validateCode'] = $validateCode;
    $_POST["pwd"] = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $_SESSION['form1'] = $_POST;
	$_SESSION['login'] = 1;
    header("Location: ../pages/emailconfirm.php");
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../pages/register1.php");
}
?>