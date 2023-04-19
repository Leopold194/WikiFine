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
            $connection= new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PWD);
        }catch (Exception $e){
            die("Erreur SQL ".$e->getMessage());
        }

        return $connection;
    }
?>