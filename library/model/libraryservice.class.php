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
        $db = DB::getConnection();
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
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_users
                        WHERE id = :userId');
        $st->execute(array(':userId' => $userId));

        $row = $st->fetch(PDO::FETCH_ASSOC);

        // Assuming 'User' is your User class, adjust as necessary
        $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);

        return $user;
    }

    function getAllExpenses()
    {
        $db = DB::getConnection();
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
        $db = DB::getConnection();
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
        $db = DB::getConnection();
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
        $db = DB::getConnection();
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

    function procesiraj_login()
    {
        // Check if username and password are provided
        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            header("Location: /balance.php?rt=login/index");
            exit;
        }

        // Get database connection
        $db = DB::getConnection();

        try {
            // Prepare and execute the SQL query to select password based on username
            $st = $db->prepare('SELECT password_hash FROM dz2_users WHERE username=:username');
            $st->execute(array(':username' => $_POST["username"]));

            // Fetch the result row
            $row = $st->fetch();

            if ($row === false) {
                // User does not exist, display appropriate message
                $errorMessage = urlencode('Ne postoji korisnik s tim imenom.');
                header("Location: /balance.php?rt=login/index&error=$errorMessage");
                exit;
            } else {
                // User exists, verify password
                $hash = $row['password_hash'];
                
                if (password_verify($_POST['password'], $hash)) {
                    // Password is correct, display successful login message
                    //$_SESSION['username'] = $_POST['username'];
                    /*setcookie( 'login', $_POST['username'] . ',' . md5( $_POST['username' ] . $secret_word ) );
                    */
                    setcookie('username', $_POST["username"], time() + 3600, '/');
                    $od = new LoginController();
                    $od->home();
                    return 1;
                } else {
                    // Password is incorrect, display appropriate message
                    $errorMessage = urlencode('Korisnik postoji no lozinka je pogrešna.');
                    header("Location: /balance.php?rt=login/index&error=$errorMessage");
                    exit;
                }
            }
        } catch (PDOException $e) {
            // Error occurred, display error message
            header("Location: /balance.php?rt=login/index");
            exit;
        }
    }

    public function addNewExpense($description, $cost, $userId, $selectedUsers)
    {
        $dateTime = date('Y-m-d H:i:s');

        // Get database connection
        $db = DB::getConnection();

        try {
            // Start a transaction
            $db->beginTransaction();

            // Insert the new expense into the expenses table
            $st = $db->prepare('INSERT INTO dz2_expenses (id_user, description, cost, date) VALUES (:userId, :description, :cost, :dateTime)');
            $st->bindValue(':userId', $userId, PDO::PARAM_INT);
            $st->bindValue(':description', $description, PDO::PARAM_STR);
            $st->bindValue(':cost', $cost, PDO::PARAM_INT);
            $st->bindValue(':dateTime', $dateTime, PDO::PARAM_STR);
            $st->execute();
            $expenseId = $db->lastInsertId(); // Get the ID of the newly inserted expense

            // Calculate the cost per user
            $numUsers = count($selectedUsers); // Including the logged-in user
            $costPerUser = $cost / $numUsers;

            // Update the logged-in user's total_paid
            $st = $db->prepare('UPDATE dz2_users SET total_paid = total_paid + :cost WHERE id = :userId');
            $st->bindValue(':cost', $cost, PDO::PARAM_INT);
            $st->bindValue(':userId', $userId, PDO::PARAM_INT);
            $st->execute();

            /*
            // Update the logged-in user's total_debt
            $st = $db->prepare('UPDATE dz2_users SET total_debt = total_debt - :costPerUser WHERE id = :userId');
            $st->bindValue(':costPerUser', $costPerUser, PDO::PARAM_INT);
            $st->bindValue(':userId', $userId, PDO::PARAM_INT);
            $st->execute();
            */
            /*
            // Insert the association between the expense and the logged-in user into the parts table
            $st = $db->prepare('INSERT INTO dz2_parts (id_expense, id_user, cost) VALUES (:expenseId, :userId, :cost)');
            $st->bindValue(':expenseId', $expenseId, PDO::PARAM_INT);
            $st->bindValue(':userId', $userId, PDO::PARAM_INT);
            $st->bindValue(':cost', $cost, PDO::PARAM_INT);
            $st->execute();
            */
            // Update each selected user's total_debt and insert into parts table
            foreach ($selectedUsers as $selectedUserId) {
                
                $st = $db->prepare('UPDATE dz2_users SET total_debt = total_debt + :costPerUser WHERE id = :selectedUserId');
                $st->bindValue(':costPerUser', $costPerUser, PDO::PARAM_INT);
                $st->bindValue(':selectedUserId', $selectedUserId, PDO::PARAM_INT);
                $st->execute();
                
                $st = $db->prepare('INSERT INTO dz2_parts (id_expense, id_user, cost) VALUES (:expenseId, :selectedUserId, :costPerUser)');
                $st->bindValue(':expenseId', $expenseId, PDO::PARAM_INT);
                $st->bindValue(':selectedUserId', $selectedUserId, PDO::PARAM_INT);
                $st->bindValue(':costPerUser', $costPerUser, PDO::PARAM_INT);
                $st->execute();
            }

            // Commit the transaction
            $db->commit();
        } catch (PDOException $e) {
            // If an error occurs, rollback the transaction
            $db->rollBack();
            // Handle the error
            throw $e;
        }
    }

    public function getUserBalances()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT id, username, total_paid, total_debt FROM dz2_users');
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function calculateNetBalances()
    {
        $userBalances = $this->getUserBalances();
        $netBalances = [];

        foreach ($userBalances as $user) {
            $netBalances[$user->id] = $user->total_paid - $user->total_debt;
        }

        return $netBalances;
    }

    public function settleUpTransactions()
    {
        $netBalances = $this->calculateNetBalances();

        $creditors = [];
        $debtors = [];

        foreach ($netBalances as $userId => $balance) {
            if ($balance > 0) {
                $creditors[$userId] = $balance;
            } elseif ($balance < 0) {
                $debtors[$userId] = -$balance;
            }
        }

        $transactions = [];

        foreach ($debtors as $debtorId => $debtAmount) {
            foreach ($creditors as $creditorId => $creditAmount) {
                if ($debtAmount == 0) break;
                if ($creditAmount == 0) continue;

                $transactionAmount = min($debtAmount, $creditAmount);

                $transactions[] = [
                    'from' => $debtorId,
                    'to' => $creditorId,
                    'amount' => $transactionAmount
                ];

                $debtors[$debtorId] -= $transactionAmount;
                $creditors[$creditorId] -= $transactionAmount;
            }
        }

        return $transactions;
    }
}

?>