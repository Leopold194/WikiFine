<?php 

    session_start();
    require '../functions.php';
    require "../../conf.inc.php";

    $searchValue = $_GET["search"];

    $connection = connectDB();
    $query = $connection->query("SELECT pseudo, id FROM ".DB_PREFIX."USER WHERE LOWER(pseudo) LIKE '".$searchValue."%'");
    $users = $query->fetchAll();
    
    echo json_encode($users);

?>