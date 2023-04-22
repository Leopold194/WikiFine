
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
    <div class="profileBlockConnected">
        <a href="">
            <img src=<?php echo FILE_PREFIX."img/page_logos/clock.svg"; ?> alt="Last" class="pageLogos clock">
        </a>
        <a href="">
            <img src=<?php echo FILE_PREFIX."img/page_logos/bell.svg"; ?> alt="Notifications" class="pageLogos">
        </a>
        <a href="">
            <img src=<?php echo FILE_PREFIX."img/page_logos/moon.svg"; ?> alt="Dark Mode" class="pageLogos">
        </a>
        <div class="avatarDiv">
            <a href="<?php echo FILE_PREFIX."pages/user/user_main.php";?>">
                <img src=<?php 
                    $result = getData(Array('avatar_nb'), $_SESSION['id']);
                    echo "../../../img_avatar/".$result[0].".png";
                ?> alt="Avatar" class="avatar">
            </a>
            <?php
                if(isVerify($_SESSION['id'])) {
            ?>
            <img src=<?php echo FILE_PREFIX."img/page_logos/verif.svg"; ?> alt="Verif" class="verif">
            <?php
                }
            ?>
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