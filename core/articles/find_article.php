<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    $searchValue = $_GET["search"];

    $connection = connectDB();
    $query = $connection->query("SELECT title, MAX(id) AS id FROM ".DB_PREFIX."ARTICLE WHERE LOWER(title) LIKE '".$searchValue."%' GROUP BY title ORDER BY version DESC");
    $articles = $query->fetchAll();

    echo json_encode($articles);

?>