<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class NewexpensesController
{
    public function index()
    {
        $ls = new LibraryService();

        $title = 'Popis svih korisnika knjižnice';
        $userList = $ls->getAllUsers();

        require_once __DIR__ . '/../view/new_expenses_index.php';
    }

    public function add()
    {
        if (isset($_POST['addExpense'])) {
            // Check if the form is submitted

            // Get form data
            $description = $_POST['description'];
            $cost = $_POST['cost'];
            $selectedUsers = isset($_POST['users']) ? $_POST['users'] : [];

            // Get the logged-in user's ID from the cookie
            if (isset($_COOKIE['username'])) {
                $username = $_COOKIE['username'];

                // Get the user's ID from the database
                $db = DB::getConnection();
                $st = $db->prepare('SELECT id FROM dz2_users WHERE username = :username');
                $st->execute(array(':username' => $username));
                $row = $st->fetch();
                if ($row !== false) {
                    $userId = $row['id'];

                    // Add the new expense
                    $ls = new LibraryService();
                    $ls->addNewExpense($description, $cost, $userId, $selectedUsers);

                    // Redirect to a page after adding the expense
                    header("Location: /balance.php?rt=newexpenses/index");
                    exit;
                } else {
                    // Handle error: User not found
                }
            } else {
                // Handle error: User not logged in
            }
        } else {
            // If the form is not submitted, redirect to the index page
            header("Location: /balance.php?rt=newexpenses/index");
            exit;
        }
    }

    
};
