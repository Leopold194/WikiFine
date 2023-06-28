<?php
    session_start();
    require '../functions.php';
    require "../../conf.inc.php";
    $authorId = getData(Array('id'), $_SESSION['id'])[0];

    $connect = connectDB();
    $query = $connect->query("SELECT date FROM ".DB_PREFIX."MESSAGE WHERE recipient=".$authorId." ORDER BY date DESC");
    $results = $query->fetchAll();
    if(!empty($results)){
    $timestamp1 = strtotime($results[0]['date']);
    $timestamp2 = time();
    $diff = $timestamp2 - $timestamp1;

    if($diff < 2){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }}
?>