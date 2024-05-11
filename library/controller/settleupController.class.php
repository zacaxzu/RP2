<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class SettleupController
{
    public function index()
    {
        $ls = new LibraryService();

        $title = 'Popis svih korisnika knjižnice';
        $userList = $ls->getAllUsers();

        require_once __DIR__ . '/../view/settleup_index.php';
    }
};
