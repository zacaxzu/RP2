<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class ExpensesController
{
    public function index()
    {
        $ls = new LibraryService();

        $userExpenses = $ls->getAllExpenses();
        //var_dump($userExpenses); // Check the fetched data

        require_once __DIR__ . '/../view/expenses_index.php';
    }

    
};
