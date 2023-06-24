<?php 
    session_start();
    require '../../core/functions.php';
    require '../../conf.inc.php';
    require '../templates/head.php'
?>
<link rel='stylesheet' href='../../css/templates/sidebar.css'>
<link rel='stylesheet' href='../../css/articles/articles.css'>
<?php
    
    require '../templates/navbar.php';
    require '../templates/sidebar.php';
    
    $id = $_GET['id']; 
    $_SESSION['articleId'] = $id;

    $connect = connectDB();
    $query = $connect->query("SELECT * FROM ".DB_PREFIX."ARTICLE WHERE id=".$id);
    $result = $query->fetch();
?>
    
<form method="POST" action="../../core/articles/article_option.php">
    <div class="popup popupClose" id="popupId">
        <img src="../../img/other/cross.png" alt="Fermer" class="closePopup" id="closePopupId">
        <p class="popupTitle">Signaler cet article :</p>
        <div class="inputColumn">
            <label for="reportTitle">Titre de votre signalement</label>
            <input type="text" id="reportTitle" name="title">
        </div>
        <div class="inputColumn">
            <label for="reportContent">Detaillez votre signalement<br><span class="condition">(min. 200 caractères)</span></label>
            <textarea id="reportContent" name="content"></textarea>
        </div>
        <div class="sendBtn">
            <button type="submit" name="report">Envoyer</button>
        </div>
    </div>
</form>

<div class="article">
    <h1 class="articleTitle"><?php echo $result['title'] ?></h1>
    <article class="articleContent"><?php echo $result['content'] ?></article>
    <form method="POST" action="../../core/articles/article_option.php">
        <div class="articleOption">
            <button type="submit" class="edit" name="edit"><img src="../../img/other/pencil.svg" alt="Editer l'article"></button>
            <div class="report" id="report"><img src="../../img/other/warning.svg" alt="Signaler l'article"></div>
            <button type="submit" class="like" name="like"><img src="../../img/other/like.svg" alt="Aimer l'article"></button>
        </div>
    </form>
    <section class="articleSummary"></section>
</div>

<script>
    const reportBtn = document.getElementById("report");
    const cross = document.getElementById("closePopupId");
    const popup =document.getElementById("popupId");

    reportBtn.addEventListener("click", () => {
        popup.classList.toggle("popupClose");
    });

    cross.addEventListener("click", () => {
        popup.classList.toggle("popupClose");
    })

</script>
</body>
</html>