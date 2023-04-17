<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <title>Wikifine</title>
    <link rel="icon" type="image/x-icon" href="img\logos\wikifineColorFavicon.png">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='css/index.css'>
    <link rel='stylesheet' href='css/templates/style.css'>
    <link rel='stylesheet' href='css/templates/navbar.css'>
    <link rel='stylesheet' href='css/templates/sidebar.css'>
</head>

<body>
    <header>
        <a href="index.php">
        <div class="logoBlock">
            <img class="logo" src="img\logos\wikifineColorFull.png" alt="logo">
            <div class="searchBarBlock">
                <input class="searchBar" type="text" name="search" placeholder="Search articles..">
            </div>
        </div>
        </a>
        <div class="profileBlock">
            <div class="login button">
                <a href="">
                    <p>Se connecter</p>
                </a>
            </div>
            <div class="register button">
                <a href="pages/register1.php">
                    <p>S'inscrire</p>
                </a>
            </div>
            <!--<div class="square button1"></div>
            <div class="square button2"></div>
            <div class="square button3"></div>
            <div class="circle profilePic"></div>-->
        </div>
    </header>
    <?php require 'pages/templates/sidebar.php'; ?>
    <div class="article">
        <div class="articleContent">
            <h1>Le nombre d'Or</h1>
            <p>Il intervient dans la construction du pentagone régulier. Ses propriétés algébriques le lient à la suite
                de
                Fibonacci et au corps quadratique ℚ(√5). Le nombre d'or s'observe aussi dans la nature (quelques
                phyllotaxies, par exemple chez les capitules du tournesol, pavage de Penrose de quasi-cristaux) ou dans
                quelques œuvres et monuments (architecture de Le Corbusier, musique de Xenakis, peinture de Dalí).</p>
            <h2>Lorem Ipsum</h2>
            <p>L'histoire de cette proportion commence à une période de l'Antiquité qui n'est pas connue avec certitude
                ; la
                première mention connue de la division en extrême et moyenne raison apparaît dans les Éléments
                d'Euclide. À
                la Renaissance, Luca Pacioli, un moine franciscain italien, la met à l'honneur dans un manuel de
                mathématiques et la surnomme « divine proportion » en l'associant à un idéal envoyé du ciel. Cette
                vision se
                développe et s'enrichit d'une dimension esthétique, principalement au cours des xixe et xxe siècles où
                naissent les termes de « section dorée » et de « nombre d'or ».
                Il est érigé en théorie esthétique et justifié par des arguments d'ordre mystique, comme une clé
                importante,
                voire explicative, dans la compréhension des structures du monde physique, particulièrement pour les
                critères de beauté et surtout d'harmonie ; sa présence est alors revendiquée dans les sciences de la
                nature
                et de la vie, proportions du corps humain ou dans les arts comme la peinture, l'architecture ou la
                musique.
                Certains artistes, tels le compositeur Xenakis ou le poète Paul Valéry ont adhéré à une partie de cette
                vision, soutenue par des livres populaires.
                À travers la médecine, l'archéologie ou les sciences de la nature et de la vie, la science infirme les
                théories de cette nature car elles sont fondées sur des généralisations abusives et des hypothèses
                inexactes.</p>

        </div>
        <div class="imgBlock">
            <img class="imgArticle" src="img\articles\spirale.gif" alt="spirale">
            <p class="imgTitle">Spirale logarithmetique</p><br>
            <p class="imgSubTitle">by Eduardo Renno in 2018</p>
        </div>
    </div>
</body>

</html>