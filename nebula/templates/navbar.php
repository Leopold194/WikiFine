</head>

<body>
    <header>
        <?php
        if (!empty($_SESSION['super_login']) && $_SESSION['super_login'] == 1) {
            ?>
            <div class="profileBlockConnected">
                <div class="avatarDiv">
                    <a href="<?php echo FILE_PREFIX . "pages/user/user_main.php"; ?>">
                        <img src="<?php
                        $result = getData(array('id'), $_SESSION['id']);
                        $connect = connectDB();
                        $query = $connect->query("SELECT avatar_link FROM " . DB_PREFIX . "USER WHERE id=" . $result[0]);
                        $profil_pic = $query->fetch()['avatar_link'];
                        echo $profil_pic;
                        ?>" alt="Avatar" class="avatar">
                    </a>
                    <?php
                    if (isVerify($_SESSION['id'])) {
                        ?>
                        <img src=<?php echo FILE_PREFIX . "img/page_logos/verif.svg"; ?> alt="Verif" class="verif">
                        <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </header>