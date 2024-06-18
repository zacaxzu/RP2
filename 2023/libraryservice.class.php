<?php

require_once __DIR__ . '/db.class.php';
require_once __DIR__ . '/kalodont.class.php';

class LibraryService
{
    function getAllKalodonti()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM kalodont');
        $st->execute();

        $kalodonti = [];
        while ($row = $st->fetch()) {
            $kalodont = new Kalodont($row['id'], $row['igra'], $row['igrac'], $row['rijec']);
            $kalodonti[] = $kalodont;
        }

        return $kalodonti;
    }

    function getAllIgraFromKalodonti($kalodontIgra)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM kalodont WHERE igra = :kalodontIgra');
        $st->execute(array(':kalodontIgra' => $kalodontIgra));

        $kalodonti = [];

        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $kalodont = new Kalodont($row['id'], $row['igra'], $row['igrac'], $row['rijec']);
            $kalodonti[] = $kalodont;
        }

        return $kalodonti;
    }

    function getKalodontById($kalodontId)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM kalodont
                        WHERE id = :kalodontId');
        $st->execute(array(':kalodontId' => $kalodontId));

        $row = $st->fetch(PDO::FETCH_ASSOC);

        return new Kalodont($row['id'], $row['igra'], $row['igrac'], $row['rijec']);
    }

    function getAllDistinctIgra(){
        $db = DB::getConnection();
        $st = $db->prepare('SELECT DISTINCT igra FROM kalodont');
        $st->execute();

        $igre = [];
        while ($row = $st->fetch()) {
            $igre[] = $row['igra'];
        }

        return $igre;
    }
}
?>