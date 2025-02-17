<?php 
  session_start();
  if($_SESSION['register'] < 1 && !isset($_SESSION['modify_account_data'])){
    header('Location: register.php');
  }
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../../core/functions.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/registers/register.css'>
<link rel='stylesheet' href='../../css/templates/captcha_buttons.css'>
<link rel='stylesheet' href='../../css/registers/emailconfirm.css'>
<?php require '../templates/navbar.php'; ?>

<?php 
    if(isset($_GET['registerStep']) && $_GET['registerStep'] < $_SESSION['register']) {
        $_SESSION['register'] = $_GET['registerStep'];
        header("Location: register.php");
    }
?>

<div class="breadcrumb">
    <span class="line"></span>
    <form class="circlesForm">
        <div class="circle1 circles <?php echo ($_SESSION['register'] == 0) ? 'activeCircle' : '' ?>"><button name="registerStep" value="0" class="breadcrumbCircle"><p>1</p></button></div>
        <div class="circle2 circles <?php echo ($_SESSION['register'] == 2) ? 'activeCircle' : '' ?>"><button name="registerStep" value="2" class="breadcrumbCircle"><p>2</p></button></div>
        <div class="circle3 circles <?php echo ($_SESSION['register'] == 3) ? 'activeCircle' : '' ?>"><button name="registerStep" value="3" class="breadcrumbCircle"><p>3</p></button></div>
    </form>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>

<div class="registerForm">
    <h2 class="formContentTitle">Vérification de l’adresse mail :</h2>
    <p class="formContent">Nous vous avons envoyé un e-mail à l'adresse <b><?php echo $_SESSION['form1']['email']; ?></b><br><br>Pour activer votre compte WikiFine, vous devez renseigner dans le champ ci-dessous le code présent dans l’e-mail.</p>
    <?php
        if(isset($_POST['0']) || isset($_POST['1']) || isset($_POST['2']) || isset($_POST['3']) || isset($_POST['4']) || isset($_POST['5'])) {
            if(count($_POST) != 6
                || !isset($_POST["0"])
                || !isset($_POST["1"])
                || !isset($_POST["2"])
                || !isset($_POST["3"])
                || !isset($_POST["4"])
                || !isset($_POST["5"]))
            {
                ?>
                <div class="alert">
                    <li>Code de Validation incorrect.</li>
                </div>
                <?php
            }else{

                $userCode = $_POST['0'].$_POST['1'].$_POST['2'].$_POST['3'].$_POST['4'].$_POST['5'];
                if(!isset($_SESSION['modify_account_data'])){
                    if($_SESSION['form1']['validateCode'] == $userCode){
                        $_SESSION['register'] = 2;
                        unset($_SESSION['form1']['validateCode']);
                        header('Location: register.php');
                    }
                }else{
                    if($_SESSION['validateCode'] == $userCode){
                        $_SESSION['modify_account_data'] = 1;
                        unset($_SESSION['validateCode']);
                        header('Location: ../../core/user/modify_user.php');
                    }
                }
                ?>
                    <div class="alert">
                        <li>Code de Validation incorrect.</li>
                    </div>
                <?php
            }
        }
    ?>
    <form method="POST">
        <div class="frame">
            <span class="forNumber forNumber0"></span>
            <span class="forNumber forNumber1"></span>
            <span class="forNumber forNumber2"></span>
            <span class="hyphen"></span>
            <span class="forNumber forNumber3"></span>
            <span class="forNumber forNumber4"></span>
            <span class="forNumber forNumber5"></span>
            <div class="inputDigitDiv">
                <div class="inputDigitLeft">
                    <input type="text" name="0" class="inputDigit inputDigit0" maxlength="1" id="firstInput" autocomplete="off">
                    <input type="text" name="1" class="inputDigit inputDigit1" maxlength="1" id="secondInput" autocomplete="off">
                    <input type="text" name="2" class="inputDigit inputDigit2" maxlength="1" id="thirdInput" autocomplete="off">
                </div>
                <div class="inputDigitRight">
                    <input type="text" name="3" class="inputDigit inputDigit3" maxlength="1" id="fourthInput" autocomplete="off">
                    <input type="text" name="4" class="inputDigit inputDigit4" maxlength="1" id="fifthInput" autocomplete="off">
                    <input type="text" name="5" class="inputDigit inputDigit5" maxlength="1" id="sixthInput" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="rowCenter mt mb">
            <button type="submit" class="submit submitActive field">CONTINUER</button>
        </div> 
    </form>
</div>
<script>
const inputs = document.querySelectorAll('input.inputDigit');

for (let i = 0; i < inputs.length; i++) {
  inputs[i].addEventListener('keydown', function(event) {
    if (event.keyCode === 8 && this.value.length === 0) {
      if (i > 0) {
        inputs[i - 1].focus();
      }
    }
  });
  inputs[i].addEventListener('input', function(event) {
    if (this.value.length === 1) {
      if (i + 1 < inputs.length) {
        inputs[i + 1].focus();
      }
    }
  });
  inputs[i].tabIndex = i + 1;
}
</script>
</body>
</html>
