<?php
require_once('../conf.inc.php');

$errors = array();
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['Nom']) ? $_POST['Nom'] : '';
    $prenom = isset($_POST['Prenom']) ? $_POST['Prenom'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
    $objet = isset($_POST['objet']) ? $_POST['objet'] : '';
    $commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

    if (empty($nom)) {
        $errors[] = 'Le champ Nom est requis.';
    }

    if (empty($prenom)) {
        $errors[] = 'Le champ Prenom est requis.';
    }

    if (empty($email)) {
        $errors[] = 'Le champ Email est requis.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Le format de l\'email est invalide.';
    }

    if (!empty($tel) && !preg_match('/^\+?[0-9]{8,15}$/', $tel)) {
        $errors[] = 'Le numéro de téléphone est invalide.';
    }

    if (empty($objet)) {
        $errors[] = 'Le champ Objet est requis.';
    }

    if (empty($commentaire)) {
        $errors[] = 'Le champ Commentaire est requis.';
    }

   
    if (count($errors) === 0) {
        $to = 'testwikifine@gmail.com'; 
        $subject = 'Nouveau message de contact depuis votre site web';
        $message = "Nom: $nom\nPrenom: $prenom\nEmail: $email\nTel: $tel\nObjet: $objet\nCommentaire:\n$commentaire";
        $headers = 'From: ' . $email . "\r\n" .
            'Reply-To: ' . $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            $success = true;
        } else {
            $errors[] = 'Une erreur s\'est produite lors de l\'envoi du message.';
        }
    }
}
