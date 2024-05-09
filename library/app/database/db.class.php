<?php
// db.class.php

class DB
{
    private static $db = null;

    private function __construct() { }
    private function __clone() { }

    public static function getConnection($hostname, $database, $username, $password)
    {
        if (DB::$db === null) {
            try {
                // Create a PDO connection using the provided parameters
                DB::$db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
                DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit('PDO Error: ' . $e->getMessage());
            }
        }
        return DB::$db;
    }
}

?>

