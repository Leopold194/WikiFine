<?php
    function cleanLastname($lastname) {
        return strtoupper(trim($lastname));
    }

    function cleanFirstname($firstname) {
        return ucwords(strtolower(trim($firstname)));
    }

    function cleanEmail($email) {
        return strtolower(trim($email));
    }

    function connectDB() {
        try{
            $connection= new PDO("mysql:host=54.36.182.0;dbname=WikiFine_Test;port=22","debian","Francis2004");
        }catch (Exception $e){
            die("Erreur SQL ".$e->getMessage());
        }

        return $connection;
    }
?>