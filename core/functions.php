<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    function cleanLastname($lastname) {
        return strtoupper(trim($lastname));
    }

    function cleanFirstname($firstname) {
        return ucwords(strtolower(trim($firstname)));
    }

    function cleanEmail($email) {
        return strtolower(trim($email));
    }

    function connectDB() {
        try{
            $connection= new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PWD);
        }catch (Exception $e){
            die("Erreur SQL ".$e->getMessage());
        }

        return $connection;
    }

    function checkDataInDB($type, $data){
        $connection = connectDB();
        $queryPrepared = $connection->prepare("SELECT * FROM ".DB_PREFIX."USER WHERE $type=:$type");
        $queryPrepared->execute([
            $type=>$data
        ]);
        $result = $queryPrepared->fetch();

        return (!empty($result)) ? true : false;
    }

    function sendMail($recipient, $subject, $body){
        
        require 'vendor/autoload.php';
	
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
            $mail->addAddress($recipient);
        
            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->CharSet = 'UTF-8';   
            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>