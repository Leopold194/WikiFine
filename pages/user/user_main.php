<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<?php require '../templates/navbar.php'; ?>

<div class="navbarUser">
    <ul>
        <li><a href="#">Mon compte</a></li>
        <li><a href="">Mes articles</a></li>
        <li><a href="user_mess.php">Messagerie</a></li>
    </ul>
</div>

<div class="userProfil">
    <div class="avatarAndNames">
        <img src=
            <?php 
                $result = getData(Array('avatar_nb'), $_SESSION['id']);
                echo "../../../img_avatar/".$result[0].".png";
            ?>
            alt="Avatar" class="avatar">
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