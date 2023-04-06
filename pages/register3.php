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
        $inputState = ["pseudo"=>"", "gender"=>"", "birthday"=>"", "adress"=>"", "country"=>"", "cp"=>"", "city"=>""];
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

    <h2 class="formContentTitle"><u>Selectionnez au moins 3 centres d'interêts :</u></h2>
    <form action="../core/registerUser3.php" method="POST">
        <div class="hobbiesForm">
            <input class="" type="checkbox" id="0" name="">
            <label for="0">Histoire</label>
            <input class="" type="checkbox" id="1" name="">
            <label for="1">Histoire</label>
            <input class="" type="checkbox" id="2" name="">
            <label for="2">Histoire</label>
            <input class="" type="checkbox" id="3" name="">
            <label for="3">Histoire</label>
            <input class="" type="checkbox" id="4" name="">
            <label for="4">Histoire</label>
            <input class="" type="checkbox" id="5" name="">
            <label for="5">Histoire</label>
            <input class="" type="checkbox" id="6" name="">
            <label for="6">Histoire</label>
            <input class="" type="checkbox" id="7" name="">
            <label for="7">Histoire</label>
            <input class="" type="checkbox" id="8" name="">
            <label for="8">Histoire</label>
            <input class="" type="checkbox" id="9" name="">
            <label for="9">Histoire</label>
            <input class="" type="checkbox" id="10" name="">
            <label for="10">Histoire</label>
            <input class="" type="checkbox" id="11" name="">
            <label for="11">Histoire</label>
        </div>
        <span class="line2"></span>
        <div class="newsletter">
            <input class="" type="checkbox" id="newsletterCheck" name="" checked>
            <label for="newsletterCheck">Oui, je souhaite recevoir la newsletter de WikiFine</label>
        </div>
        <div class="cgu">
            <input class="" type="checkbox" id="cguCheck" name="" required>
            <label for="cguCheck">J’accepte les <a href="google.fr" class="cguLink">Conditions Générales d’Utilisation</a></label>
        </div>
        
    </form> 
</div>
</body>
</html>