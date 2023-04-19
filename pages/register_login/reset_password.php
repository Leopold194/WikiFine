<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/templates/register.css'>
<link rel='stylesheet' href='../../css/registers/reset_password.css'>
<?php require '../templates/navbar.php'; ?>

<div class="formTitle">
    <h1 class="title">Mot de passe oublié</h1>
</div>

<div class="loginForm">
    <?php
        $inputState = ["id"=>""];
        if(!empty($_SESSION['errors'])){
    ?>
    <div class="alert">
        <?php 
            foreach($_SESSION['errors'] as $error){
                echo "<li>".$error[1]."</li>";
                $inputState[$error[0]] = "error";
            }
        ?>
    </div>
    <?php
        unset($_SESSION['errors']);}
    ?>
    <form action="../../core/register_login/reset_functions.php" method="POST">
        <div class="text">
            <p>Entrez votre adresse mail ou votre pseudonyme et nous vous enverrons un mot de passe temporaire</p>
        </div>
        <div class="email field <?php echo $inputState["id"]; ?>">
            <input type="text" class="inputForm" name="id" placeholder="Email ou Pseudonyme" required>
            <label class="placeholderLabel">Email ou Pseudonyme</label>
        </div>
        <div class="submit field">
            <button type="submit">ENVOYER</button>
        </div>
        </div></div>
    </form> 
</div>
</body>
</html>