<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    $connect = connectDB();

    if(isset($_POST['edit'])){

        $query = $connect->query("SELECT * FROM ".DB_PREFIX."ARTICLE WHERE id=".$_SESSION['articleId']);
        $articleData = $query->fetch();

        $query = $connect->query("SELECT category FROM ".DB_PREFIX."BELONGTO WHERE article=".$_SESSION['articleId']);
        $categories = $query->fetchAll();

        $_SESSION['articleData']['title'] = $articleData['title'];
        $cpt = 0;
        foreach($categories as $category) {
            $_SESSION['articleData']['selectCtg'.$cpt] = $category['category'];
            $cpt++;
        }
        $_SESSION['articleData']['content'] = $articleData['content'];
        $_SESSION['action'] = 'modif';

        header('Location: ../../pages/articles/write_article.php');

    }elseif(isset($_POST['report'])){
        
        if(!isset($_SESSION['id'])) {
            header('Location: ../../pages/register_login/login.php');
            exit();
        }
        
        $result = getData(Array('id'), $_SESSION['id']);
        $query = $connect->prepare("INSERT INTO ".DB_PREFIX."REPORTING (article, title, content, author) VALUES (:article, :title, :content, :author)");
        $query->execute([
            "article"=>$_SESSION['articleId'],
            "title"=>$_POST['title'],
            "content"=>$_POST['content'],
            "author"=>$result[0]
        ]);

        header('Location: ../../pages/articles/articles.php?id='.$_SESSION['articleId']);

    }elseif(isset($_POST['like'])){
        $queryForLikeNb = $connect->query("SELECT like_nb FROM ".DB_PREFIX."ARTICLE WHERE id=".$_SESSION['articleId']);
        $likeNb = $queryForLikeNb->fetch();
        $newLikeNb = $likeNb['like_nb'] + 1;
        $query = $connect->query("UPDATE ".DB_PREFIX."ARTICLE SET like_nb=".$newLikeNb." WHERE id=".$_SESSION['articleId']);

        header('Location: ../../pages/articles/articles.php?id='.$_SESSION['articleId']);

    }


?>