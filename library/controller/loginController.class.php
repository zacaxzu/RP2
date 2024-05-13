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
        else
            require_once __DIR__ . '/../view/login_forma.php';
    }

    public function home()
    {
        require_once __DIR__ . '/../view/home_html.php';
    }

    public function logout()
    {
        $ls = new LibraryService();
        
        // Check if logout button is clicked
        if (isset($_POST['logout'])) {
            $ls->logout();
            var_dump($_POST['logout']);
            header("Location: /balance.php?rt=login/index");
        }
    }
}
