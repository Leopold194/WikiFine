<?php
session_start();
require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/templates/sidebar.css'>
<link rel='stylesheet' href='../../css/index.css'>
<link rel='stylesheet' href='../../css/articles/write_article.css'>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/sidebar.php'; ?>

<div class="contentPage">

    <div class="titlePage">
        <h1>Bienvenue dans la création d'articles !</h1>
        <p>Avant de commencer à rédiger ton article, n’hésite pas à aller lire <a href="">le règlement</a></p>
    </div>

    <div class="articleCreation">
        <form method="POST" action="../../core/articles/publish_article.php">

            <div class="articleTitle">
                <p class="desc">Tout d’abord, de quoi souhaites tu parler ?</p>
                <div class="inputDiv">
                    <input type="text" placeholder="Titre de l'article" name="title" maxlength="50">
                    <p>0/50</p>
                </div>
            </div>

            <div class="articleContent">
                <p class="desc">Maintenant détaille nous ce sujet :</p>
                <div class="utils">
                    <div class="bold"><b>G</b></div>
                    <div class="italic"><i>I</i></div>
                    <div class="underline"><u>S</u></div>
                    <div class="strikethrough"><s>B</s></div>
                    <div class="color"><div class="circle">&nbsp;</div></div>
                    <div class="size"><select><option>Paragraphe</option><option>Titre</option><option>Sous-Titre</option></select></div>
                    <div class="puces"><img src="../../img/other/puces.png" alt="puces"></div>
                    <div class="numbers"><img src="../../img/other/numbers.png" alt="numbers"></div>
                    <div class="img"><img src="../../img/other/img.png" alt="images"></div>
                    <div class="link"><img src="../../img/other/link.png" alt="link"></div>
                </div>
                <div class="textareaDiv">
                    <textarea type="text" placeholder="" name="content"></textarea>
                </div>
            </div>

            <div class="articleSummary">
                <p class="desc">Fiche descriptive :</p>
                <div class="container">
                    <div class="summaryImg"><input type='file' name='poster' id="poster"><label for="poster" id="posterLabel">+</label></div>
                </div>
            </div>

            <button type="submit" class="publishBtn">Publier</button>

        </form>
    </div>
</div>

<script>
    var input = document.getElementById("poster");
    var preview = document.querySelector(".summaryImg");
    var label = document.getElementById("posterLabel");

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