<?php 
  session_start();
  if($_SESSION['login'] < 2){
    header('Location: register1.php');
  }
  $_SESSION['login'] = 2;
?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/templates/register.css'>
<link rel='stylesheet' href='../css/registers/register2.css'>
<?php require 'templates/navbar.php'; ?>

<div class="breadcrumb">
    <span class="line"></span>  
    <div class="circle1 circles"><a class="breadcrumbCircle" href="register1.php"><p>1</p></a></div>
    <div class="circle2 circles activeCircle"><a class="breadcrumbCircle" href="#"><p>2</p></a></div>
    <div class="circle3 circles"><a class="breadcrumbCircle" href="register3.php"><p>3</p></a></div>
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
    <form action="../core/registerUser.php" method="POST">
        <div class="avatar field">
            <a href=""><img src="../img/register/avatar.png" alt="avatarMenu"></a>
        </div>
        <div class="pseudo field tiny-mt <?php echo $inputState["pseudo"]; ?>">
            <input type="text" class="inputForm" name="pseudo" id="pseudo" placeholder="Pseudonyme" required>
            <label class="placeholderLabel">Prénom</label>
        </div>
        <div class="gender field mt <?php echo $inputState["gender"]; ?>">

            <input type="radio" id="gender0" name="gender" checked value="0">
            <label for="gender0">M.</label>
    
            <input type="radio" id="gender1" name="gender" value="1">
            <label for="gender1">Mme.</label>

            <input type="radio" id="gender2" name="gender" value="2">
            <label for="gender2">Autre</label>


        </div>
        <div class="birthday field mt <?php echo $inputState["birthday"]; ?>">
            <input type="date" class="inputForm" name="birthday" placeholder="Date de naissance" required>
            <label class="placeholderLabel">Date de naissance</label>
        </div>
        <div class="adress field mt <?php echo $inputState["adress"]; ?>">
            <input type="adress" class="inputForm" name="adress" placeholder="Adresse" required>
            <label class="placeholderLabel">Adresse</label>
        </div>
        <div class="country field mt <?php echo $inputState["country"]; ?>">
            <input type="country" class="inputForm" name="country" placeholder="Pays" required>
            <label class="placeholderLabel">Pays</label>
        </div>
        <div class="cp field mt <?php echo $inputState["cp"]; ?>">
            <input type="password" class="inputForm" name="cp" placeholder="Code postal" required>
            <label class="placeholderLabel">Code postal</label>
        </div>
        <div class="city field mt <?php echo $inputState["city"]; ?>">
            <input type="password" class="inputForm" name="city" placeholder="Ville" required>
            <label class="placeholderLabel">Ville</label>
        </div>
        <div class="submit field">
            <button type="submit">CONTINUER</button>
        </div>    
    </form> 
</div>
</body>
</html>