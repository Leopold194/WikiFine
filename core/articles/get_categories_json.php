<?php
    require '../core/functions.php';

    $connect = connectDB();
    $results = $connect->query("SELECT id, title, description, logo FROM ".DB_PREFIX."CATEGORY");
    $listOfCategories = $results->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($listOfCategories);
?>
