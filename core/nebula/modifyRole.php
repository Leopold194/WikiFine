<?php
    session_start();
    require '../functions.php';
    require "../../conf.inc.php";
    
    if(isset($_POST["choice"])){
        $data = explode("|", $_POST["choice"]);

        $connect = connectDB();
        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET status=:status WHERE id=:id");
        $queryPrepared->execute([
            "status"=>$data[0],
            "id"=>$data[1]
        ]);
    }

    if(isset($_POST["verify"])){
        
        if(isVerify($_POST['verify'], "id")) {
            $verify = 0;
        }else{
            $verify = 1;
        }
        
        $connect = connectDB();
        $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET verify=:verify WHERE id=:id");
        $queryPrepared->execute([
            "verify"=>$verify,
            "id"=>$_POST["verify"]
        ]);
    }

?>