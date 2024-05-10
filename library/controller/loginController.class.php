<?php
require_once 'model/UserModel.php';

class LoginController
{
    public function index()
    {
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
    }
}
