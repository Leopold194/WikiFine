<div class="captcha captchaClose">
    <p>Vérification</p>
    <img src = <?php echo FILE_PREFIX."img/captcha/captcha_src/captcha.png"; ?> alt="Captcha completé" class="completedCaptcha">
    <div class="captchaContainer">
        <?php 
            $captchaCodes = [0, 1, 2, 3, 4, 5, 6, 7, 8];
            shuffle($captchaCodes);
            foreach($captchaCodes as $code) {
                echo "<div class='puzzlePiece' draggable='true'><img src='".FILE_PREFIX."img/captcha/captcha_cut/captcha".$code.".png' alt='Image du Captcha' class='captchaImg' id='".$code."' draggable='true'></div>";
            }
        ?>
    </div>
    <div id="captchaBtn" class="captchaBtnDisabled">Valider</div>
</div>