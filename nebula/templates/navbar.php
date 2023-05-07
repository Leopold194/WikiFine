
</head>
<body>
<header>
    <div class="logoBlock">
        <a href=<?php echo FILE_PREFIX."index.php";?>><img class="logoNebula" src=<?php echo FILE_PREFIX."img\logos\\nebulaColorFull.png"; ?> alt="logo"></a>
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
        }
    ?>
</header>