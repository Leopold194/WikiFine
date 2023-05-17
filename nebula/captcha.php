<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/captcha.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<div class="pageBody">
    <h1 class="pageTitle">Mise en place du captcha :</h1>
    <div class="container">
        <div class="newCaptchaDiv">
            <p class="desc">Choisir une image pour le captcha :</p>
            <form method="POST" action="../core/nebula/change_captcha.php" enctype="multipart/form-data">
                <div class="summaryImg"><input type='file' name='captcha' id="captcha"><label for="captcha" id="captchaLabel">+</label></div>
                <input type="submit">
            </form>
            <p class="warning">/!\ Elle sera recadrée au format 1:1 /!\</p>
        </div>
        <div class="previousCaptchaDiv">
            <p class="desc">Image de captcha actuelle :</p>
            <img class="previousCaptcha" src="../img/captcha/captcha_src/captcha.png" alt="Ancien Captcha">
        </div>
    </div>
</div>

<script>
    var input = document.getElementById("captcha");
    var preview = document.querySelector(".summaryImg");
    var label = document.getElementById("captchaLabel");

    input.addEventListener("change", function () {
        var file = this.files[0];
        
        if (file) {
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.style.backgroundImage = "url('" + reader.result + "')";
            preview.style.backgroundSize = "contain";
            preview.style.backgroundPosition = "center";
            preview.style.backgroundRepeat = "no-repeat";
            preview.style.backgroundColor = "#ffffff";
            label.style.display = "none";
        });

        reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html>