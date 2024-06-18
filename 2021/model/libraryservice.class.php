<?php
    require_once __DIR__ . '/../database/db.class.php';
    require_once __DIR__ . '/user.class.php';


class LibraryService
{
    function getAllStudenti()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM studenti');
        $st->execute();

        $studenti = [];
        while ($row = $st->fetch()) {
            $student = new Student($row['id'], $row['ime'], $row['kolegij']);
            $studenti[] = $student;
        }

        return $studenti;
    }

    function getAllStudentiFromKolegij($kolegijIme)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM studenti WHERE kolegij = :kolegijIme');
        $st->execute(array(':kolegijIme' => $kolegijIme));

        $studenti = [];

        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $student = new Student($row['id'], $row['ime'], $row['kolegij']);
            $studenti[] = $student;
        }

        return $studenti;
    }

    function getAllProstorije()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM prostorije');
        $st->execute();

        $prostorije = [];
        while ($row = $st->fetch()) {
            $prostorija = new Prostorija($row['id'], $row['ime']);
            $prostorije[] = $prostorija;
        }

        return $prostorije;
    }

    function getStudentById($studentId)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM studenti
                        WHERE id = :studentId');
        $st->execute(array(':studentId' => $studentId));

        $row = $st->fetch(PDO::FETCH_ASSOC);

        // Assuming 'User' is your User class, adjust as necessary
        if ($row) {
            return new Student($row['id'], $row['ime'], $row['kolegij']);
        }
        else {
            return null;
        }
    }
}
?>