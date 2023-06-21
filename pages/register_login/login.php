<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/registers/register.css'>
<link rel='stylesheet' href='../../css/registers/login.css'>
<link rel='stylesheet' href='../../css/templates/captcha_buttons.css'>
<script src=<?php echo FILE_PREFIX.'js/see_password.js'; ?> defer></script>
<script src=<?php echo FILE_PREFIX.'js/captcha.js'; ?> defer></script>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/captcha.php'; ?>


<div class="formTitle">
    <h1 class="title">Connexion</h1>
</div>

<div class="loginForm">
    
    <?php
        if(!empty($_SESSION['errors'])){
            ?>
            <div class="alert">
                <li><?php echo $_SESSION['errors']; ?></li>
            </div>
            <?php
            unset($_SESSION['errors']);
        }
    ?>
    <form method="POST" id="loginFormData" action="../../core/register_login/login_core.php">
        <div class="email field">
            <input type="text" class="inputForm" name="id" placeholder="Email ou Pseudonyme" required>
            <label class="placeholderLabel">Email ou Pseudonyme</label>
        </div>
        <div class="pwd field mt">
            <input type="password" class="inputForm" name="pwd" id="pwd" placeholder="Mot de passe" required>
            <img src="../../img/register/open_eye.png" class="eye open_eye" id="eye0">
            <label class="placeholderLabel">Mot de passe</label>
        </div>
        <div class="link mt">
            <a href="register1.php">Vous n’avez pas de compte ? Inscrivez vous dès maintenant !</a><br>
            <a href="reset_password.php">Mot de passe oublié</a>
        </div>
        <div class="rowCenter mt mb">
            <div class="captchaBtnCheckOrUncheck captchaBtnCheck tiny-mr">CAPTCHA</div>
            <div class="submit submitInactive field tiny-ml" id="connBtn">CONNEXION</div>
        </div>
    </form> 
</div>
</body>
</html>