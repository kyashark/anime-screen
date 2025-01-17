<?php

require_once 'config.php';

class Database{
    public static function connect(){
        $connection = null;
        try{
            $connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
                DB_USER, 
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
        return $connection;
    }  
}