<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    $connect = connectDB();

    if(isset($_POST['edit'])){

    }elseif(isset($_POST['report'])){
        $result = getData(Array('id'), $_SESSION['id']);
        $query = $connect->query("INSERT INTO ".DB_PREFIX."REPORTING (article, title, content, author) VALUES (".$_SESSION['articleId'].", '".$_POST['title']."', '".$_POST['content']."', ".$result[0].")");
    }elseif(isset($_POST['like'])){
        $queryForLikeNb = $connect->query("SELECT like_nb FROM ".DB_PREFIX."ARTICLE WHERE id=".$_SESSION['articleId']);
        $likeNb = $queryForLikeNb->fetch();
        $newLikeNb = $likeNb['like_nb'] + 1;
        $query = $connect->query("UPDATE ".DB_PREFIX."ARTICLE SET like_nb=".$newLikeNb." WHERE id=".$_SESSION['articleId']);
    }

    header('Location: ../../pages/articles/articles.php?id='.$_SESSION['articleId'])

?>