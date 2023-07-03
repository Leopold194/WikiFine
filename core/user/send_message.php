<?php
    session_start();
    require '../functions.php';
    require "../../conf.inc.php";
    $authorId = getData(Array('id'), $_SESSION['id'])[0];
    if(isset($_POST['content'])) {
        $connect = connectDB();
        $query = $connect->prepare("INSERT INTO ".DB_PREFIX."MESSAGE (content, author, recipient) VALUES (:content, :author, :recipient)");
        $query->execute([
            "content" => htmlspecialchars($_POST['content']),
            "author" => $authorId,
            "recipient" => $_POST['recipient']
        ]);
    }
    header("Location: ../../pages/user/user_mess.php?recipientId=".$_POST['recipient']);
?>