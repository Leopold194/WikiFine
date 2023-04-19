<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/templates/register.css'>
<link rel='stylesheet' href='../../css/registers/login.css'>
<?php require '../templates/navbar.php'; ?>

<div class="formTitle">
    <h1 class="title">Connexion</h1>
</div>

<div class="loginForm">
    
    <?php
        if(!empty($_POST['pwd']) && !empty($_POST['id'])){
			
            $pseudo = $_POST['id'];
            $email = cleanEmail($_POST['id']);

            $connection = connectDB();
            $queryPrepared = $connection->prepare("SELECT password, email FROM ".DB_PREFIX."USER WHERE (email=:email OR pseudo=:pseudo)");
            $queryPrepared->execute([
                "email"=>$email,
                "pseudo"=>$pseudo
            ]);
            $result = $queryPrepared->fetch();

            if(!empty($result) && password_verify($_POST['pwd'], $result['password'])){
                $_SESSION['id'] = $result["email"];
                $_SESSION['login'] = 1;
                header('Location: ../../index.php');
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
    <form method="POST">
        <div class="email field">
            <input type="text" class="inputForm" name="id" placeholder="Email ou Pseudonyme" required>
            <label class="placeholderLabel">Email ou Pseudonyme</label>
        </div>
        <div class="pwd field mt">
            <input type="password" class="inputForm" name="pwd" id="pwd" placeholder="Mot de passe" required>
            <img src="../../img/register/open_eye.svg" class="eye open_eye" id="eye0">
            <label class="placeholderLabel">Mot de passe</label>
        </div>
        <div class="link mt">
            <a href="register1.php">Vous n’avez pas de compte ? Inscrivez vous dès maintenant !</a><br>
            <a href="reset_password.php">Mot de passe oublié</a>
        </div>
        <div class="submit field">
            <button type="submit">CONNEXION</button>
        </div>
        </div></div>
    </form> 
</div>
<script>

const eye0 = document.getElementById("eye0");
const passwordField = document.getElementById("pwd");

eye0.addEventListener("click", () => {
  if(eye0.classList.contains('open_eye')){
    eye0.src = "../../img/register/close_eye.svg";
    passwordField.type = "text";
    eye0.classList.add('close_eye');
    eye0.classList.remove('open_eye');
  }else{
    eye0.src = "../../img/register/open_eye.svg";
    passwordField.type = "password";
    eye0.classList.add('open_eye');
    eye0.classList.remove('close_eye');
  }
});

</script>
</body>
</html>