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
            $connection= new PDO("mysql:host=localhost;dbname=projet_web_1a4;port=3306","root","");
        }catch (Exception $e){
            die("Erreur SQL ".$e->getMessage());
        }

        return $connection;
    }
?>