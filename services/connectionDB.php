<?php

class connectionDB {

    protected static $db;

    private function __construct() {
        try {
            $db_host = "localhost";
            $db_user = "root";
            $db_pass = "";
            $db_name = "api_titosburguer";
            
            self::$db = new PDO("mysql:host=$db_host; dbname=$db_name",
                             $db_user, $db_pass);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }

    public static function connect() {
        if(!self::$db) {
            new connectionDB();
        }

        return self::$db;
    }

}