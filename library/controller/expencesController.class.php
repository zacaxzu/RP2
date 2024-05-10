<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class ExpencesController
{
    public function index()
    {
        $ls = new LibraryService();

        $title = 'Popis svih korisnika knjižnice';
        $userList = $ls->getAllUsers();

        require_once __DIR__ . '/../view/expences_index.php';
    }
};
