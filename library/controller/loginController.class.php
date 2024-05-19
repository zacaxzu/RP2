<?php
require_once 'model/UserModel.php';
require_once __DIR__ . '/../model/libraryservice.class.php';

class LoginController
{
    public function index()
    {
        $ls = new LibraryService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gumb']))
        {
            if($_POST["gumb"] === "login"){
                setcookie('username', $_POST["username"], time() + 3600, '/');
                return $ls->procesiraj_login();
            }
        } 
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gumb'])) {
            if($_POST["gumb"] === "registracija"){
                // Redirect to the registration controller
                $registracijaController = new RegistracijaController();
                $registracijaController->index();
            }
            else if ($_POST["gumb"] === "novi") {
                // Redirect to the registration controller
                $registracijaController = new RegistracijaController();
                $registracijaController->index();
            }
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
        session_start();

        session_unset();
        session_destroy();

        // Redirect the user to the login page
        require_once __DIR__ . '/../view/login_forma.php';
    }
}
