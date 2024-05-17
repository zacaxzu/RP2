<?php
// db.class.php

class DB
{
    private static $db = null;

    private function __construct() { }
    private function __clone() { }

    public static function getConnection()
    {
        if (DB::$db === null) {
            try {
                // Create a PDO connection using the provided parameters
                DB::$db = new PDO("mysql:host=rp2.studenti.math.hr;dbname=baca;charset=utf8", 'student', 'pass.mysql');
                DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit('PDO Error: ' . $e->getMessage());
            }
        }
        return DB::$db;
    }
}

?>

