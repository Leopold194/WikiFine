<?php 
    require '../functions.php';
    require "../../conf.inc.php";

    $connection = connectDB();
    $query = $connection->query("SELECT id FROM ".DB_PREFIX."ARTICLE");
    $articles = $query->fetchAll();

    $articlesId = Array();

    foreach($articles as $article) {
        $articlesId[] = $article['id'];
    }

    $id = $articlesId[array_rand($articlesId)];

    header("Location: ../../pages/articles/articles.php?id=".$id);
?>