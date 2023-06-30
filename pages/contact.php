<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?>
<?php require 'templates/navbar.php'; ?>
<style>
    <?php include '../css/contact.css'; ?>
</style>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../core/vendor/autoload.php';

$data = file_get_contents('../../secrets/secrets.json');
$obj = json_decode($data);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();

    if (empty($_POST['Nom'])) {
        $errors[] = "Le champ Nom est obligatoire.";
    }

    if (count($errors) == 0) {
        $mail = new PHPMailer(true);

        try {
            // Configuration des paramètres SMTP
            $mail->isSMTP();
            $mail->Host       = $obj[0]->HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $obj[0]->USERNAME;
            $mail->Password   = $obj[0]->SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $obj[0]->PORT;

            // Destinataire et contenu du message
            $mail->setFrom($obj[0]->USERNAME, $obj[0]->ADRESS_NAME);
            $mail->addAddress($_POST['Email']);

            $mail->isHTML(true);
            $mail->Subject = $_POST['objet'];
            
            $header = 'Nom: ' . $_POST['Nom'] . '<br>';
            $header .= 'Prénom: ' . $_POST['Prenom'] . '<br>';
            $header .= 'Téléphone: ' . $_POST['tel'] . '<br><br>';

            $mail->Body    = $header . $_POST['commentaire'];


            $mail->send();

            echo 'Le message a été envoyé';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur du serveur de messagerie : {$mail->ErrorInfo}";
        }
    }
}
?>

<div class="formTitle">
    <h1 class="title">Contactez-nous</h1>
</div>
<div class="contactForm">
    <?php if (isset($success) && $success) { ?>
        <div class="success">
            Votre message a été envoyé avec succès !
        </div>
    <?php } else if (isset($errors) && count($errors) > 0) { ?>
        <div class="error">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo $error ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <form method="POST" action="">
        <div class="container">
            <div class="nameinput">
                <div class="lastname">
                    <input type="text" class="lastname inputForm" name="Nom" placeholder="Nom" value="<?php echo isset($_POST['Nom']) ? $_POST['Nom'] : '' ?>" required>
                </div>
                <div class="firstnameForm">
                    <input type="text" class="firstname inputForm" name="Prenom" placeholder="Prénom" value="<?php echo isset($_POST['Prenom']) ? $_POST['Prenom'] : '' ?>" required>
                </div>
            </div>
            <div class="email">
                <input type="email" class="email inputForm" name="Email" placeholder="Email" value="<?php echo isset($_POST['Email']) ? $_POST['Email'] : '' ?>" required>
            </div>
            <div class="telForm">
                <div class="tel">
                    <input type="tel" class="tel inputForm" name="tel" placeholder="Téléphone">
                </div>
                <div class="tel1">
                    <select class="selectForm inputForm" name="country">
                        <option value="0">+33</option>
                    </select>
                </div>
            </div>
            <div class="objet">
                <input type="text" class="object inputForm" name="objet" placeholder="Objet" required>
            </div>
            <div class="commentaire">
                <textarea id="commentaire" name="commentaire" required></textarea>
            </div>
            <div class="rowCenter mt mb">
            <button type="submit" class="submit submitActive field">CONTINUER</button>
        </div> 
        </div>
    </form>
</div>
