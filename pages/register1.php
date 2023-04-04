<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/templates/register.css'>
<link rel='stylesheet' href='../css/registers/register1.scss'>
<?php require 'templates/navbar.php'; ?>

<div class="breadcrumb">
    <span class="line"></span>  
    <div class="circle1 circles activeCircle"><a class="breadcrumbCircle" href="#"><p>1</p></a></div>
    <div class="circle2 circles"><a class="breadcrumbCircle" href="register2.php"><p>2</p></a></div>
    <div class="circle3 circles"><a class="breadcrumbCircle" href="register3.php"><p>3</p></a></div>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>
<!--
<div class="col-3 input-effect">
    <input class="inputForm" type="text" placeholder="">
    <label>Prénom</label>
    <span class="focus-border">
        <i></i>
    </span>
</div>
-->
<div class="registerForm">
    <form action="emailConfirm.php" method="POST">
        <div class="firstname field">
            <input type="text" class="inputForm" name="firstname" id="firstname" placeholder="Prénom" required>
            <label for="firstname">Prénom</label>
        </div>
        <div class="lastname field">
            <input type="text" class="inputForm" name="lastname" placeholder="Nom" required>
            <label>Nom</label>
        </div>
        <div class="email field">
            <input type="email" class="inputForm" name="email" placeholder="Email" required>
            <label>Email</label>
        </div>
        <div class="country field">
            <select class="selectForm" placeholder=" ">
                <option>+33</option>
                <option>+93</option>
            </select>
        </div>
        <div class="tel field">
            <input type="tel" class="inputForm" name="tel" placeholder="Téléphone" required>
            <label>Téléphone</label>
        </div>
        <div class="pwd field">
            <input type="password" class="inputForm" name="pwd" placeholder="Mot de passe" required>
            <label>Mot de passe</label>
        </div>
        <div class="pwdConfirm field">
            <input type="password" class="inputForm" name="pwdConfirm" placeholder="Confirmation" required>
            <label>Confirmation</label>
        </div>
        <div class="submit field">
            <button type="submit" name="register">CONTINUER</button>
        </div>    
    </form> 
</div>



</body>
</html>