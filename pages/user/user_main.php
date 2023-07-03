<?php 
    session_start();
    require '../../core/functions.php';
    redirectIfNotConnected();
?>

<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/user_sidebar.php'; ?>

<div class="userProfil">
    <div class="avatarAndNames">
    <a href="<?php echo FILE_PREFIX . "pages/user/user_main.php"; ?>">
                        <img src="<?php
                        $result = getData(array('id'), $_SESSION['id']);
                        $connect = connectDB();
                        $query = $connect->query("SELECT avatar_link FROM ".DB_PREFIX."USER WHERE id=".$result[0]);
                        $profil_pic = $query->fetch()['avatar_link'];
                        echo $profil_pic;
                        ?>" alt="Avatar" class="avatarUser" style="width:200px; height:200px">
                    </a>
                    <?php
                    if (isVerify($_SESSION['id'])) {
                        ?>
                        <img src=<?php echo FILE_PREFIX . "img/page_logos/verif.svg"; ?> alt="Verif" class="verifUser">
                        <?php
                    }
                    ?>
        <div class="textName">
            <p class="fullName"><?php 
                $result = getData(Array('firstname', 'lastname'), $_SESSION['id']);
                echo ucwords($result[0])." ".ucwords($result[1]);
            ?></p>
            <p class="pseudo"><?php 
                $result = getData(Array('pseudo'), $_SESSION['id']);
                echo $result[0];
            ?></p>
            <div class="buttonToModify">
            <a href="user_modif.php">Modifier mon profil</a>
            </div>
        </div>
    </div>
    
    <!--
    <div class="network">
        <a href=""><img src="../../img/network_logos/black_insta.png" alt="Instagram"></a>
        <a href=""><img src="../../img/network_logos/black_twitter.png" alt="Twitter"></a>
        <a href=""><img src="../../img/network_logos/black_linkedin.png" alt="Linkedin"></a>
        <a href=""><img src="../../img/network_logos/black_discord.png" alt="Discord"></a>
    </div>
    -->

    <div class="descriptionContainer">
        <div class="description">
            <p class="descriptionTitle">Qui suis-je ?</p>
            <p class="descriptionContent"><?php 
                $result = getData(Array('description'), $_SESSION['id']);
                echo $result[0];
            ?></p>
        </div>
    </div>
</div>

<div class="userArticles">
    <div class="lastArticle">
        <p class="articleType">Mon dernier article</p>
        <div class="articleContainer"><div class="article"></div></div>
    </div>
    <div class="mostLikedArticle">
        <p class="articleType">Mon article le plus aimé</p>
        <div class="articleContainer"><div class="article"></div></div>
    </div>
</div>


</body>
</html>