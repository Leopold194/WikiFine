<?php 
    session_start();
    require '../../core/functions.php';
    redirectIfNotConnected();
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<link rel='stylesheet' href='../../css/user/messages.css'>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/user_sidebar.php'; ?>



<div class="container">
    <form method="POST" action="../../core/user/send_message.php">
        <div class="sendMess">
            <input type="text" placeholder="Écris ton message ici ...">
            <button type="submit" class="sendBtn"><img src="../../img/other/send.png" alt="Envoyer le message"></button>
        </div>
    </form>
    <div class="contact">
        &nbsp;
    </div>
</div>


</body>
</html>