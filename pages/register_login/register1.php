<?php 
    session_start();
    $_SESSION['register'] = 0;
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/templates/register.css'>
<link rel='stylesheet' href='../../css/registers/register1.css'>
<?php require '../templates/navbar.php'; ?>

<div class="breadcrumb">
    <span class="line"></span>  
    <div class="circle1 circles activeCircle"><a class="breadcrumbCircle" href="#"><p>1</p></a></div>
    <div class="circle2 circles"><a class="breadcrumbCircle" href="register2.php"><p>2</p></a></div>
    <div class="circle3 circles"><a class="breadcrumbCircle" href="register3.php"><p>3</p></a></div>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>

<div class="registerForm">
    <?php
        $inputState = ["firstname"=>"", "lastname"=>"", "email"=>"", "country"=>"", "tel"=>"", "pwd"=>"", "pwdConfirm"=>""];
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
    <form action="../../core/register_login/register_user_1.php" method="POST">
        <div class="firstname field <?php echo $inputState["firstname"]; ?>">
            <input type="text" class="inputForm" name="firstname" id="firstname" placeholder="Prénom" required>
            <label class="placeholderLabel">Prénom</label>
        </div>
        <div class="lastname field <?php echo $inputState["lastname"]; ?>">
            <input type="text" class="inputForm" name="lastname" placeholder="Nom" required>
            <label class="placeholderLabel">Nom</label>
        </div>
        <div class="email field mt <?php echo $inputState["email"]; ?>">
            <input type="email" class="inputForm" name="email" placeholder="Email" required>
            <label class="placeholderLabel">Email</label>
        </div>
        <div class="country field mt <?php echo $inputState["country"]; ?>">
            <select class="selectForm" name="country" placeholder=" ">
                <option value="0">+33</option>
                <option value="1">+93</option>
            </select>
        </div>
        <div class="tel field mt <?php echo $inputState["tel"]; ?>">
            <input type="tel" class="inputForm" name="tel" placeholder="Téléphone" required>
            <label class="placeholderLabel">Téléphone</label>
        </div>
        <div class="pwd field mt <?php echo $inputState["pwd"]; ?>">
            <input type="password" class="inputForm" id="pwd" name="pwd" placeholder="Mot de passe" required>
            <img src="../../img/register/open_eye.svg" class="eye open_eye" id="eye0">
            <label class="placeholderLabel">Mot de passe</label>
        </div>
        <div class="pwdConfirm field mt <?php echo $inputState["pwdConfirm"]; ?>">
            <input type="password" class="inputForm" id="pwdConfirm" name="pwdConfirm" placeholder="Confirmation" required>
            <img src="../../img/register/open_eye.svg" class="eye open_eye" id="eye1">
            <label class="placeholderLabel">Confirmation</label>
        </div>
        <div class="submit field">
            <button type="submit">CONTINUER</button>
        </div>    
    </form> 
</div>
<script>

const eye0 = document.getElementById("eye0");
const eye1 = document.getElementById("eye1");
const passwordField = document.getElementById("pwd");
const passwordConfirmField = document.getElementById("pwdConfirm");

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

eye1.addEventListener("click", () => {
  if(eye1.classList.contains('open_eye')){
    eye1.src = "../../img/register/close_eye.svg";
    passwordConfirmField.type = "text";
    eye1.classList.add('close_eye');
    eye1.classList.remove('open_eye');
  }else{
    eye1.src = "../../img/register/open_eye.svg";
    passwordConfirmField.type = "password";
    eye1.classList.add('open_eye');
    eye1.classList.remove('close_eye');
  }
});

</script>
</body>
</html>