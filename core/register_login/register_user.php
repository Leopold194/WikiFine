<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require "../functions.php";
require "../../conf.inc.php";

if($_SESSION['register'] == 0){

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

	if(strlen($_POST["lastname"]) < 2){$listOfErrors[] = ["lastname", "Le nom doit faire plus de 2 caractères"];}
	if(strlen($_POST["firstname"]) < 2){$listOfErrors[] = ["firstname", "Le prénom doit faire plus de 2 caractères"];}

	$listOfCities = [0,1];
	if(!in_array($_POST['country'], $listOfCities) ){$listOfErrors[] = ["country", "L'extension téléphone n'est pas valide"];}

	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){$listOfErrors[] = ["email", "L'email est incorrect"];}
	else{if(checkDataInDB("email", $_POST['email'])) {$listOfErrors[] = ["email", "Vous avez déjà un compte"];}}

	//Adapter à tous les numéros de téléphone du monde
	if(!preg_match("#^0?[1-9]([ -]?[0-9]{2}){4}$#", $_POST["tel"])){$listOfErrors[] = ["tel", "Numéro de téléphone invalide"];}
	else{if(strlen($_POST["tel"]) == 9) {$_POST["tel"] = "0".$_POST["tel"];}}

	if( strlen($_POST["pwd"])<8
		|| !preg_match("#[a-z]#", $_POST["pwd"])
		|| !preg_match("#[A-Z]#", $_POST["pwd"])
		|| !preg_match("#[?!._&]#", $_POST["pwd"])
		|| !preg_match("#[0-9]#", $_POST["pwd"]))
	{
		$listOfErrors[] = ["pwd", "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules, des chiifres et des caractères spéciaux (?!._&)"];
	}

	if($_POST["pwd"] != $_POST["pwdConfirm"]){$listOfErrors[] = ["pwdConfirm", "Votre mot de passe de confirmation ne correspond pas"];}

	if(empty($listOfErrors)){
		$validateCode = "";
		for($cpt = 0; $cpt < 6; $cpt++){$validateCode .= strval(rand(0, 9));}

		require '../vendor/autoload.php';
		
		$data = file_get_contents('../../../secrets/secrets.json');
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
		$_SESSION['register'] = 1;
		header("Location: ../../pages/register_login/email_confirm.php");
	}else{
		$_SESSION['errors']= $listOfErrors;
		header("Location: ../../pages/register_login/register.php");
	}

}elseif($_SESSION['register'] == 2) {
	
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
	$_POST["country"] = trim(strtolower($_POST["country"]));
	$_POST["cp"] = trim($_POST["cp"]);
	$_POST["city"] = trim(strtolower($_POST["city"]));

	$listOfErrors = [];

	$pattern = "#^[a-z0-9-_]{3,30}$#i";
	if(!preg_match($pattern, $_POST['pseudo'])) {$listOfErrors[] = ["pseudo", "Pseudonyme incorrect : Entre 3 et 30 caractères, pas de caractères spéciaux (à part - et _)"];}
	else{if(checkDataInDB("pseudo", $_POST['pseudo'])) {$listOfErrors[] = ["pseudo", "Pseudo déjà existant"];}}

	$birthdaySeparate = explode("-", $_POST['birthday']);

	if(!checkdate($birthdaySeparate[1], $birthdaySeparate[2], $birthdaySeparate[0])){$listOfErrors[] = ["birthday", "Format de date incorrect"];}
	else{
		$todaySecond = time();
		$birthdaySecond = strtotime($_POST['birthday']);
		$ageSecond = $todaySecond - $birthdaySecond;
		$age = $ageSecond/60/60/24/365.25;
		if($age < 6) {$listOfErrors[] = ["birthday", "Vous n'avez pas l'âge requis"];}
	}

	$listOfGenders = [0,1,2];
	if(!in_array($_POST['gender'], $listOfGenders) ){$listOfErrors[] = ["gender", "Le genre n'existe pas"];}

	$pattern = "#^[0-9]{1,4} ?,? ?[a-zA-Z0-9\s']{1,40}$#i";
	if(!preg_match($pattern, $_POST['adress'])) {$listOfErrors[] = ["adress", "Adresse incorrect, doit être au format : 47, rue du 14 Juillet"];}

	$pattern = "#^[a-z\s-]{4,40}$#i";
	if(!preg_match($pattern, $_POST['country'])) {$listOfErrors[] = ["country", "Pays incorrect"];}

	$pattern = "#^[0-9]{5}$#i";
	if(!preg_match($pattern, $_POST['cp'])) {$listOfErrors[] = ["cp", "Code postal invalide"];}

	if(empty($listOfErrors)){
		$_SESSION['form2'] = $_POST;
		$_SESSION['register'] = 3;
	}else{
		$_SESSION['errors']= $listOfErrors;
	}
	header("Location: ../../pages/register_login/register.php");

}elseif($_SESSION['register'] == 3) {
	
	$listOfErrors = [];

	if(!isset($_POST["cgu"])) {$listOfErrors[] = "Vous devez accepter les Conditions Générales d'Utilisation";}

	if(!array_key_exists('interest', $_POST) || count($_POST['interest']) < 3){$listOfErrors[] = "Vous devez selectionnez au moins 3 centres d'intérêt dans la liste";}

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
		header("Location: ../../pages/register_login/register.php");
	}
}
?>