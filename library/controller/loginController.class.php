<?php
require_once 'model/UserModel.php';
require_once __DIR__ . '/../model/libraryservice.class.php';

class LoginController
{
    public function index()
    {
        $ls = new LibraryService();

        if (isset($_POST["gumb"]) && $_POST["gumb"] === "login")
            $ls->procesiraj_login();
        //else if( isset( $_POST["gumb" ] ) && $_POST["gumb"] === "novi" )
        //	procesiraj_novi();
        else
            $ls->crtaj_loginForma();

        /*
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                echo "Login successful!";
            } else {
                // Login failed
                echo "Incorrect username or password";
            }
        }

        // Load the login view
        require_once dirname(__DIR__) . '/app/database/db.class.php';
        */
    }
}
