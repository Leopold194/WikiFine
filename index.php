<?php
    session_start();
    require 'core/functions.php';
?>

<?php require 'conf.inc.php'; ?>
<?php require 'pages/templates/head.php'; ?>
<link rel='stylesheet' href='css/templates/sidebar.css'>
<link rel='stylesheet' href='css/index.css'>
<?php require 'pages/templates/navbar.php'; ?>
<?php require 'pages/templates/sidebar.php'; ?>


<body>
    <div class="contentIndex">
        <div class="welcomeTitle">
            <h1>Amuses-toi bien sur Wikifine !</h1>
        </div>
        <h1 class="recommendationsTitle">Les articles les plus likés</h1>
        <div class="recommendationFrame">
            <?php 
                $connect = connectDB();
                $query = $connect->query("SELECT * FROM ".DB_PREFIX."ARTICLE ORDER BY like_nb DESC LIMIT 3");
                $articles = $query->fetchAll();

                foreach($articles as $article) {
            ?>
            <div class="recommendationCard">
                <div class="cardHead">
                    <h2 class="cardTitle"><a class="cardTitleLink" href="pages/articles/articles.php?id=<?php echo $article['id'] ?>"><?php echo $article['title'] ?></a></h2>
                    <img class="cardImage" src="<?php echo $article['img'] ?>" alt="Image de couverture">
                </div>
                <div class="cardContentContainer"><p class="cardContent"><?php echo $article['content'] ?></p></div>
            </div>
            <?php
                }
            ?>
        </div>
        <h1 class="recommendationsTitle">Les derniers articles publiés</h1>
        <div class="recommendationFrame">
            <?php 
                $connect = connectDB();
                $query = $connect->query("SELECT * FROM ".DB_PREFIX."ARTICLE ORDER BY date DESC LIMIT 3");
                $articles = $query->fetchAll();

                foreach($articles as $article) {
            ?>
            <div class="recommendationCard">
                <div class="cardHead">
                    <h2 class="cardTitle"><a class="cardTitleLink" href="pages/articles/articles.php?id=<?php echo $article['id'] ?>"><?php echo $article['title'] ?></a></h2>
                    <img class="cardImage" src="<?php echo $article['img'] ?>" alt="Image de couverture">
                </div>
                <div class="cardContentContainer"><p class="cardContent"><?php echo $article['content'] ?></p></div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>

</html>