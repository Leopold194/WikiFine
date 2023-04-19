</head>
<body>
<header>
    <div class="logoBlock">
        <a href=<?php echo FILE_PREFIX."index.php";?>><img class="logo" src=<?php echo FILE_PREFIX."img\logos\wikifineColorFull.png"; ?> alt="logo"></a>
        <div class="searchBarBlock">
            <input class="searchBar" type="text" name="search" placeholder="Search articles..">
        </div>
    </div>
    <?php
        if(!empty($_SESSION['login']) && $_SESSION['login'] == 1) {
    ?>
    <div class="profileBlock">
        <div class="login button">
            <a href=<?php echo FILE_PREFIX."pages/register_login/login.php"; ?>><p>Se déconnecter</p></a>
        </div>
        <div class="register button">
            <a href=<?php echo FILE_PREFIX."pages/register_login/register1.php"; ?>><p>Mon profil</p></a>
        </div>
    </div>
    <?php 
        }else{
    ?>
    <div class="profileBlock">
        <div class="login button">
            <a href=<?php echo FILE_PREFIX."pages/register_login/login.php"; ?>><p>Se connecter</p></a>
        </div>
        <div class="register button">
            <a href=<?php echo FILE_PREFIX."pages/register_login/register1.php"; ?>><p>S'inscrire</p></a>
        </div>
    </div>
    <?php 
        }
    ?>
</header>