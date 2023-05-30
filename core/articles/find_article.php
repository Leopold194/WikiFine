<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    $searchValue = $_GET["search"];

    $connection = connectDB();
    $query = $connection->query("SELECT title, id FROM ".DB_PREFIX."ARTICLE WHERE LOWER(title) LIKE '".$searchValue."%'");
    $articles = $query->fetchAll();

    echo json_encode($articles);

?>