<?php
require_once 'model/UserModel.php';
require_once __DIR__ . '/../model/libraryservice.class.php';

class LoginController
{
    public function index()
    {
        $ls = new LibraryService();

        if (isset($_POST["gumb"]) && $_POST["gumb"] === "login")
        {
            setcookie('username', $_POST["username"], time() + 3600, '/');
            return $ls->procesiraj_login();
        }
        else
            require_once __DIR__ . '/../view/login_forma.php';
    }

    public function home()
    {
        require_once __DIR__ . '/../view/home_html.php';
    }

    public function logout()
    {
        setcookie('username', '', time() - 3600, '/');

        // Redirect the user to the login page
        require_once __DIR__ . '/../view/login_forma.php';
    }
}
