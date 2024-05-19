<?php

require_once __DIR__ . '/../model/libraryservice.class.php';
require_once __DIR__ . '/../app/database/db.class.php';

class RegistracijaController
{
    public function index()
    {
        require_once __DIR__ . '/../view/registracija_html.php';
    }

    public function registracija()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        //echo $username;

        $us = new LibraryService();
        $result = $us->registracijaKorisnika($username, $email, $password);

        //echo "$result";

        if ($result) {
            require_once __DIR__ . '/../view/registracija_zahvala_html.php';
        } else {
            require_once __DIR__ . '/../view/registracija_ponovno_html.php';
        }
    }

    public function confirm()
    {
        $registrationSequence = $_GET['sequence'];

        $us = new LibraryService();
        $result = $us->potvrdiRegistraciju($registrationSequence);

        //echo $result;

        if ($result) {
            require_once __DIR__ . '/../view/potvrda_registracije_uspjesna_html.php';
        } else {
            require_once __DIR__ . '/../view/potvrda_registracije_neuspjesna_html.php';
        }
    }
};
