<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    if(isset($_POST['content'])) {
        $connect = connectDB();
        $query = $connect->prepare("INSERT INTO ".DB_PREFIX."MESSAGE (content, author, recipient) VALUES (content=:content, author=:author, recipient=:recipient)");
        $query->execute([
            "content" => $_POST['content'],
            "author" => getData(Array('id'), $_SESSION['id']),
            "recipient" => ""
        ]);
    }

?>