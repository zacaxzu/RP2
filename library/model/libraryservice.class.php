<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/expense.class.php';
//require_once __DIR__ . '/book.class.php';

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
            // Create Expense objects and add them to the expenses array
            $expense = new Expense($row['id'], $row['id_user'], $row['cost'], $row['description'], $row['date']);
            $expenses[] = $expense;
        }

        return $expenses;
    }

    /*
    function getAllBooks()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM books');
        $st->execute();

        $books = [];
        while($row = $st->fetch())
        {
            $book = new Book($row['id'], $row['author'], $row['title']);
            $books[] = $book;
        }

        return $books;
    }

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