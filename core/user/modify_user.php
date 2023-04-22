<?php

session_start();
require "../functions.php";
require "../../conf.inc.php";

if(!isset($_SESSION['modify_account_data'])){

    $listOfErrors = [];
    $COLUMNS_TO_MODIFY = [];
    $correct = true;

    foreach($_POST as $key => $value){
        if(!empty($value)){
            $COLUMNS_TO_MODIFY[] = $key;
            switch($key){
                case 'lastname':
                    $_POST["lastname"] = cleanLastname($_POST["lastname"]);
                    if(strlen($_POST["lastname"]) < 2){$listOfErrors[] = ["lastname", "Le nom doit faire plus de 2 caractères"];}
                    break;
                case 'firstname':
                    $_POST["firstname"] = cleanFirstname($_POST["firstname"]);
                    if(strlen($_POST["firstname"]) < 2){$listOfErrors[] = ["firstname", "Le prénom doit faire plus de 2 caractères"];}
                    break;
                case 'pseudo':
                    $_POST['pseudo'] = trim($_POST['pseudo']);
                    $pattern = "#^[a-z0-9-_]{3,30}$#i";
                    if(!preg_match($pattern, $_POST['pseudo'])) {$listOfErrors[] = ["pseudo", "Pseudonyme incorrect : Entre 3 et 30 caractères, pas de caractères spéciaux (à part - et _)"];}
                    else{if(checkDataInDB("pseudo", $_POST['pseudo'])) {$listOfErrors[] = ["pseudo", "Pseudo déjà existant"];}}
                    break;
                case 'phone':
                    $_POST["phone"] = trim($_POST["phone"]);
                    if(!preg_match("#^0?[1-9]([ -]?[0-9]{2}){4}$#", $_POST["tel"])){$listOfErrors[] = ["tel", "Numéro de téléphone invalide"];}
                    else{if(strlen($_POST["tel"]) == 9) {$_POST["tel"] = "0".$_POST["tel"];}}
                    break;
                case 'address':
                    $_POST["adress"] = trim($_POST["adress"]);
                    $pattern = "#^[0-9]{1,4} ?,? ?[a-zA-Z0-9\s']{1,40}$#i";
                    if(!preg_match($pattern, $_POST['adress'])) {$listOfErrors[] = ["adress", "Adresse incorrect, doit être au format : 47, rue du 14 Juillet"];}
                    break;
                case 'cp':
                    $_POST["post_code"] = trim($_POST["post_code"]);
                    $pattern = "#^[0-9]{5}$#i";
                    if(!preg_match($pattern, $_POST['cp'])) {$listOfErrors[] = ["cp", "Code postal invalide"];}
                    break;
                case 'city':
                    $_POST["cty"] = trim(strtolower($_POST["city"]));
                    break;
                case 'country':
                    $_POST["country"] = trim(strtolower($_POST["country"]));
                    $pattern = "#^[a-z\s]{4,40}$#i";
                    if(!preg_match($pattern, $_POST['country'])) {$listOfErrors[] = ["country", "Pays incorrect"];}
                    break;
                case 'email';
                    $_POST["email"] = cleanEmail($_POST["email"]);
                    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){$listOfErrors[] = ["email", "L'email est incorrect"];}
                    else{if(checkDataInDB("email", $_POST['email'])) {$listOfErrors[] = ["email", "Cet email appartient déjà a un compte"];}}
                    break;
                case 'previousPwd' || 'confirmPwd' || 'password':
                    if($correct){
                        if(empty($_POST['previousPwd']) || empty($_POST['confirmPwd']) || empty($_POST['password'])){$listOfErrors[] = ["previousPwd", "Pour changer de mot de passe vous devez renseigner le mot de passe actuel, le nouveau et le confirmer"]; $correct=false;}
                        if(strlen($_POST["password"])<8 || !preg_match("#[a-z]#", $_POST["password"]) || !preg_match("#[A-Z]#", $_POST["password"]) || !preg_match("#[!?._&]#", $_POST["password"]) || !preg_match("#[0-9]#", $_POST["password"])){$listOfErrors[] = ["password", "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules, des chiffres et des caractères spéciaux (?!._&)"]; $correct=false;}
                        if($_POST["password"] != $_POST["confirmPwd"]){$listOfErrors[] = ["confirmPwd", "Votre mot de passe de confirmation ne correspond pas".$_POST['password'].$_POST['confirmPwd']]; $correct=false;}
                        
                        if($correct){
                            $connection = connectDB();
                            $queryPrepared = $connection->prepare("SELECT password FROM ".DB_PREFIX."USER WHERE email=:email");
                            $queryPrepared->execute([
                                "email"=>$_SESSION['id'],
                            ]);
                            $result = $queryPrepared->fetch();

                            if(empty($result) || !password_verify($_POST['previousPwd'], $result['password'])){
                                $listOfErrors[] = ['previousPwd', 'Votre ancien mot de passe est incorrect'];
                            }
                        }
                    }   
                    break;
            }
        }
    }

}

if(empty($listOfErrors)){

    if(!empty($_POST['email'])){
        
        $validateCode = "";
        for($cpt = 0; $cpt < 6; $cpt++){
            $validateCode .= strval(rand(0, 9));
        }
        
        sendMail(
        $_POST['email'], 
        'Confirmation par e-mail', 
        '<center>
        <a href="www.wikifine.org"><img src="https://drive.google.com/uc?id=1NMNel1OLhMk-XW22pAGLg2ZRvIznSSNo" alt="Logo">
        </a><br><br><br><h1>Te voilà arrivé sur WikiFine !</h1><br><br><h3>Prêt à apprendre pleins de nouvelles choses, 
        et épater tout le monde en repas de famille ?</h3><br><i>Nous devons vérifier ton adresse e-mail. Pour ce faire, 
        saisi le code de confirmation suivant :</i><br><br><br><span style="font-size: 50px;">'.$validateCode.'</span><br><br><br><br><br><br><br><i>Ce mail a 
        été généré automatiquement, merci de ne pas y répondre.
        </center>'
        );
    
        $_SESSION['validateCode'] = $validateCode;
        $_SESSION['modify_account_data'] = 0;
        $_SESSION['form1']['email'] = $_POST['email'];
        header("Location: ../../pages/register_login/email_confirm.php");
    }

    if(!isset($_SESSION['modify_account_data']) || $_SESSION['modify_account_data'] == 1){
        
        if(!empty($COLUMNS_TO_MODIFY)){
            
            if(!empty($_POST['password'])){
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                unset($COLUMNS_TO_MODIFY[array_search('confirmPwd', $COLUMNS_TO_MODIFY)], $COLUMNS_TO_MODIFY[array_search('previousPwd', $COLUMNS_TO_MODIFY)]);
            }

            $columns = "";
            foreach($COLUMNS_TO_MODIFY as $COLUMN){
                $columns = $columns.$COLUMN."='".$_POST[$COLUMN]."', ";
            }
            
            $columns = substr($columns, 0, -2);

            $connect = connectDB();
            //".$columns."
            $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET ".$columns." WHERE email=:email");
            $queryPrepared->execute([
                "email"=>$_SESSION['id']
            ]);

            if(!empty($_POST['email'])){$_SESSION['id'] = $_POST['email'];}
            unset($_SESSION['form1']['email']);
            unset($_SESSION['modify_account_data']);
        }
        header("Location: ../../pages/user/user_main.php");
    }
}else{
    $_SESSION['errors']= $listOfErrors;
    header("Location: ../../pages/user/user_modif.php");
}
?>