<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/expense.class.php';
require_once __DIR__ . '/part.class.php';
require_once __DIR__ . '/partexpense.class.php';
require_once __DIR__ . '/userexpense.class.php';
require_once __DIR__ . '/userpartexpense.class.php';

class LibraryService
{
    function getAllUsers()
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_users');
        $st->execute();

        $users = [];
        while ($row = $st->fetch()) {
            $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);
            $users[] = $user;
        }

        return $users;
    }

    function getUserByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_users
                        WHERE id = :userId');
        $st->execute(array(':userId' => $userId));

        $row = $st->fetch(PDO::FETCH_ASSOC);

        // Assuming 'User' is your User class, adjust as necessary
        $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);

        return $user;
    }
    /*
    function getAllExpensesByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT e.id 
                            AS expense_id, e.id_user 
                            AS expense_user_id, e.description 
                            AS expense_description, e.cost 
                            AS expense_cost, e.date 
                            AS expense_date, p.id 
                            AS part_id, p.id_user 
                            AS part_user_id, p.cost 
                            AS part_cost, u.username
                            FROM dz2_parts p
                            JOIN dz2_expenses e ON p.id_expense = e.id
                            JOIN dz2_users u ON e.id_user = u.id
                            WHERE p.id_user = :userId');
        $st->execute(array('userId' => $userId));

        $userPartExpenses = [];
        while ($row = $st->fetch()) {
            $userPartExpense = new UserPartExpense(
                $row['expense_user_id'],
                $row['part_id'],
                $row['expense_id'],
                $row['expense_cost'],
                $row['part_cost'],
                $row['username'],
                $row['expense_description'],
                $row['expense_date']
            );
            $userPartExpenses[] = $userPartExpense;
        }

        return $userPartExpenses;

        /*
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $st = $db->prepare('SELECT * FROM dz2_expenses WHERE id_user = :userId');
        $st->execute(array('userId' => $userId));

        $expenses = [];
        while ($row = $st->fetch()) {
            $expense = new Expense($row['id'], $row['id_user'], $row['cost'], $row['description'], $row['date']);
            $expenses[] = $expense;
        }

        return $expenses;
        */
    //}

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

    function getAllExpensesByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $sql = "SELECT e.id AS expense_id, e.id_user, e.cost, e.description, e.date, u.username 
            FROM dz2_expenses e 
            JOIN dz2_users u 
            ON e.id_user = u.id
            WHERE e.id_user = :userId";

        $st = $db->prepare($sql);
        $st->execute(array(':userId' => $userId));

        $expenses = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $expense = new UserExpense($row['expense_id'], $row['id_user'], $row['username'], $row['cost'], $row['description'], $row['date']);
            $expenses[] = $expense;
        }
        return $expenses;
    }

    function getAllPartsByUserId($userId)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $sql = "SELECT p.id AS id_part, p.id_expense, p.id_user, p.cost AS part_cost,
                e.id AS expense_id, e.cost AS expense_cost, e.description, e.date,
                u.username
                FROM dz2_parts p
                JOIN dz2_expenses e ON p.id_expense = e.id
                JOIN dz2_users u ON e.id_user = u.id
                WHERE p.id_user = :userId";

        $st = $db->prepare($sql);
        $st->execute(array(':userId' => $userId));

        $parts = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $part = new UserPartExpense($row['id_user'], $row['id_part'], $row['id_expense'], $row['expense_cost'], $row['part_cost'], $row['username'], $row['description'], $row['date']);
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

        $usersPartsExpenses = [];
        while ($row = $st->fetch()) {
            $usersPartsExpense = new UserPartExpense($row['id_user'], $row['id_part'], $row['id_expense'], $row['expense_cost'], $row['part_cost'], $row['username'], $row['description'], $row['date']);
            $usersPartsExpenses[] = $usersPartsExpense;
        }
        // $id_user, $id_part, $id_expense, $expense_cost, $part_cost, $username, $description, $date
        return $usersPartsExpenses;
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

    function procesiraj_login()
    {
        session_start();
        // Check if username and password are provided
        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            crtaj_loginForma();
            return;
        }

        // Get database connection
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');

        try {
            // Prepare and execute the SQL query to select password based on username
            $st = $db->prepare('SELECT password_hash FROM dz2_users WHERE username=:username');
            $st->execute(array(':username' => $_POST["username"]));

            // Fetch the result row
            $row = $st->fetch();

            if ($row === false) {
                // User does not exist, display appropriate message
                crtaj_loginForma('Ne postoji korisnik s tim imenom.');
                return;
            } else {
                // User exists, verify password
                $hash = $row['password_hash'];

                if (password_verify($_POST['password'], $hash)) {
                    // Password is correct, display successful login message
                    $_SESSION['username'] = $_POST['username'];
                    header("Location: /balance.php?rt=users/index"); // Redirect to the appropriate view
                    exit;
                } else {
                    // Password is incorrect, display appropriate message
                    crtaj_loginForma('Postoji korisnik, ali lozinka nije ispravna.');
                    return;
                }
            }
        } catch (PDOException $e) {
            // Error occurred, display error message
            crtaj_loginForma('Greška prilikom provjere korisnika: ' . $e->getMessage());
            return;
        }
    }

    function crtaj_loginForma($message = '')
    {
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf8" />
            <title>Login</title>
        </head>

        <body>
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                Korisničko ime:
                <input type="text" name="username" />
                <br />
                Password:
                <input type="password" name="password" />
                <br />
                <button type="submit" name="gumb" value="login">Ulogiraj se!</button>
                <button type="submit" name="gumb" value="novi">Stvori novog korisnika!</button>
            </form>

            <?php
            if ($message !== '')
                echo '<p>' . $message . '</p>';
            ?>
        </body>

        </html>
    <?php
    }
   
    function crtaj_uspjesnoUlogiran()
    {
    
        require_once __DIR__ . '/_header.php'; 
        ?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf8" />
            <title>Login</title>
            <link rel="stylesheet" href="login.css" />
        </head>

        <body>
            Čestitam uspješno ste se ulogirali <?php echo htmlspecialchars($_POST['username']); ?>!
        </body>

        </html>
        <?php require_once __DIR__ . '/_footer.php'; ?>
    <?php
    }
}

?>