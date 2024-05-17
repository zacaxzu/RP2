<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class SettleupController
{
    public function index()
    {
        $ls = new LibraryService();

        // Get the settle up transactions
        $transactions = $ls->settleUpTransactions();

        // Pass the transactions to the view
        require_once __DIR__ . '/../view/settleup_index.php';
    }
};
