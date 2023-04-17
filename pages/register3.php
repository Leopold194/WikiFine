<?php 
  session_start();
  if($_SESSION['login'] < 2){
    header('Location: register1.php');
  }else if($_SESSION['login'] < 3){
    header('Location: register2.php');
  }
  $_SESSION['login'] = 3;
?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/templates/register.css'>
<link rel='stylesheet' href='../css/registers/register3.css'>
<?php require 'templates/navbar.php'; ?>

<div class="breadcrumb">
    <span class="line"></span>  
    <div class="circle1 circles"><a class="breadcrumbCircle" href="register1.php"><p>1</p></a></div>
    <div class="circle2 circles"><a class="breadcrumbCircle" href="register2.php"><p>2</p></a></div>
    <div class="circle3 circles activeCircle"><a class="breadcrumbCircle" href="#"><p>3</p></a></div>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>

<div class="registerForm">
    <?php
        if(!empty($_SESSION['errors'])){
    ?>
    <div class="alert">
        <?php 
            foreach($_SESSION['errors'] as $error){
                echo "<li>".$error."</li>";
            }
        ?>
    </div>
    <?php
        unset($_SESSION['errors']);}
    ?>
    <h2 class="formContentTitle"><u>Selectionnez au moins 3 centres d'intérêts :</u></h2>
    <form action="../core/registerUser3.php" method="POST">
        <div class="hobbiesForm">
            <input class="" type="checkbox" id="0" name="interest[]" value="0">
            <label for="0">Histoire</label>
            <input class="" type="checkbox" id="1" name="interest[]" value="1">
            <label for="1">Technologie</label>
            <input class="" type="checkbox" id="2" name="interest[]" value="2">
            <label for="2">Musique</label>
            <input class="" type="checkbox" id="3" name="interest[]" value="3">
            <label for="3">Sciences</label>
            <input class="" type="checkbox" id="4" name="interest[]" value="4">
            <label for="4">Environnement</label>
            <input class="" type="checkbox" id="5" name="interest[]" value="5">
            <label for="5">Politique</label>
            <input class="" type="checkbox" id="6" name="interest[]" value="6">
            <label for="6">Arts</label>
            <input class="" type="checkbox" id="7" name="interest[]" value="7">
            <label for="7">Géographie</label>
            <input class="" type="checkbox" id="8" name="interest[]" value="8">
            <label for="8">Cinéma</label>
            <input class="" type="checkbox" id="9" name="interest[]" value="9">
            <label for="9">Sport</label>
            <input class="" type="checkbox" id="10" name="interest[]" value="10">
            <label for="10">Littérature</label>
            <input class="" type="checkbox" id="11" name="interest[]" value="11">
            <label for="11">Religion</label>
        </div>
        <span class="line2"></span>
        <div class="newsletter">
            <input class="" type="checkbox" id="newsletterCheck" name="newsletter" checked>
            <label for="newsletterCheck">Oui, je souhaite recevoir la newsletter de WikiFine</label>
        </div>
        <div class="cgu">
            <input type="checkbox" id="cguCheck" name="cgu" onClick="changeClass()">
            <label for="cguCheck">J’accepte les <a href="google.fr" class="cguLink">Conditions Générales d’Utilisation</a></label>
        </div>
        <div class="buttons">
            <a href="">
                <div class="captchaButton">
                    <p>Captcha</p>
                    <img src="../img/register/tete_robot.svg" alt="">
                </div>
            </a>
            <button type="submit" id="registerButton" class="registerButtonInactive" disabled>S'inscrire</button>
        </div>
    </form> 
</div>
<script>
function changeClass(){
    let check = document.getElementById('cguCheck');
    let button = document.getElementById('registerButton');

    if(check.checked == true){
        button.className = 'registerButtonActive';
        button.disabled = false
    }else{
        button.className = 'registerButtonInactive';
        button.disabled = true
    }}
</script>  

</body>
</html>