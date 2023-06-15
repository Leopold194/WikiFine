<?php
    session_start();
    require '../functions.php';
    require "../../conf.inc.php";
    
    if(count($_POST) != 3
        || empty($_POST["title"])
        || empty($_POST["content"])
        || empty($_POST["poster"]))
    {
        die("Une erreur est survenue");
    }

    $listOfErrors = [];

    if(strlen($_POST["title"]) > 50){
        $listOfErrors[] = ["title", "Le titre de votre article fait plus de 50 caractères"];
    }

    $listOfImgs = "(['mainPoster'] => ".$_POST["poster"].")";

    $result = getData(Array('id'), $_SESSION['id']);

    echo $listOfImgs;
    echo $result[0];

    $connection = connectDB();
    $query=$connection->prepare("INSERT INTO ".DB_PREFIX."ARTICLE (title, content, img, author) VALUES (:title, :content, :img, :author)");
    $query->execute([
        "title"=>$_POST['title'],
        "content"=>$_POST['content'],
        "img"=>$listOfImgs,
        "author"=>$result[0]
    ]);

?>