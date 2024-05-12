<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/expense.class.php';
require_once __DIR__ . '/part.class.php';
require_once __DIR__ . '/partexpense.class.php';
require_once __DIR__ . '/userexpense.class.php';

class LibraryService
{
    function getAllUsers()
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_users');
        $st->execute();

        $users = [];
        while($row = $st->fetch())
        {
            $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);
            $users[] = $user;
        }

        return $users;
    }

    function getAllExpensesByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_expenses WHERE id_user = :userId');
        $st->execute(array('userId' => $userId));

        $expenses = [];
        while ($row = $st->fetch()) {
            $expense = new Expense($row['id'], $row['id_user'], $row['cost'], $row['description'], $row['date']);
            $expenses[] = $expense;
        }

        return $expenses;
    }

    function getAllExpenses()
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $sql = "SELECT e.id 
                AS expense_id, e.id_user, e.cost, e.description, e.date, u.username 
                FROM dz2_expenses e 
                JOIN dz2_users u 
                ON e.id_user = u.id";

        $st = $db->prepare($sql);
        $st->execute();

        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $expense = new UserExpense($row['expense_id'], $row['id_user'], $row['username'], $row['cost'], $row['description'], $row['date']);
            $expenses[] = $expense;
        }
        return $expenses;
    }

    function getAllPartsByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_parts WHERE id_user = :userId');
        $st->execute(array('userId' => $userId));

        $parts = [];
        while ($row = $st->fetch()) {
            $part = new Part($row['id'], $row['id_expense'], $row['id_user'], $row['cost']);
            $parts[] = $part;
        }

        return $parts;
    }

    function getExpenseDescriptionByExpenseId($expenseId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT p.*, e.description 
                        AS expense_description 
                        FROM dz2_parts p 
                        JOIN dz2_expenses e 
                        ON p.id_expense = e.id 
                        WHERE p.id_expense = :expense_id');
        $st->execute(array('expense_id' => $expenseId));

        $expensesDescriptions = [];
        while ($row = $st->fetch()) {
            $expensesDescription = new PartExpense($row['id'], $row['id_expense'], $row['id_user'], $row['cost'], $row['description'], $row['date']);
            $expensesDescriptions[] = $expensesDescription;
        }

        return $expensesDescriptions;
    }
    
/*
    function search()
    {
        $title = 'Pretzraživanje knjiga po autoru';
        require_once __DIR__ . '/::/view/books_search.php';
    }

    function searchResults()
    {
        $author = $_POST['author'];

        $ls = new LibraryService();
        $bookList = $ls->getBooksByAuthor($author);

    }
    */
}

?>