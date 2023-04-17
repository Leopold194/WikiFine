<?php 
    session_start();
    require '../core/loginUser.php';
    require '../core/functions.php';
?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/templates/register.css'>
<link rel='stylesheet' href='../css/registers/login.css'>
<?php require 'templates/navbar.php'; ?>

<div class="formTitle">
    <h1 class="title">Connexion</h1>
</div>

<div class="loginForm">
    
    <?php
        if(!empty($_POST['pwd']) && !empty($_POST['email'])){
					
            $email = cleanEmail($_POST['email']);
            
            $connection = connectDB();
            $queryPrepared = $connection->prepare("SELECT password FROM WF_USER WHERE email=:email");
            $queryPrepared->execute([
                "email"=>$email
            ]);
            $result = $queryPrepared->fetch();

            if(!empty($result) && password_verify($_POST['pwd'], $result['password'])){
                $_SESSION['email'] = $email;
                $_SESSION['login'] = 4;
                header('Location: ../index.php');
            }else{
    ?>
    <div class="alert">
        <?php 
            echo "<li>Identifiant ou Mot de passe incorrect.</li>";}
        ?>
    </div>
    <?php
        }
    ?>
    <form ="" method="POST">
        <div class="email field">
            <input type="email" class="inputForm" name="email" placeholder="Email ou Pseudonyme" required>
            <label class="placeholderLabel">Email ou Pseudonyme</label>
        </div>
        <div class="pwd field mt">
            <input type="password" class="inputForm" name="pwd" placeholder="Mot de passe" required>
            <label class="placeholderLabel">Mot de passe</label>
        </div>
        <div class="link mt">
            <a href="">Vous n’avez pas de compte ? Inscrivez vous dès maintenant !</a><br>
            <a href="">Mot de passe oublié</a>
        </div>
        <div class="submit field">
            <button type="submit">CONNEXION</button>
        </div>
        </div></div>
    </form> 
</div>
</body>
</html>