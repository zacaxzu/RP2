<?php

// Function to route the request based on GET parameters

    if (!isset($_GET['rt'])) {
        $con = 'login';
        $action = 'index';
    } else {
        $rt = $_GET['rt'];
        $x = explode('/', $rt);
        if (count($x) === 1) {
            $con = $x[0];
            $action = 'index';
        } else {
            $con = $x[0];
            $action = $x[1];
        }
    }

    $controllerName = $con . 'Controller';
    $controllerFile = __DIR__ . '/controller/' . $controllerName . '.class.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $c = new $controllerName();
        $c->$action();
    } else {
        // Handle error: Controller not found
        echo "Controller not found.";
    }

/*
// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gumb'])) {
        if ($_POST['gumb'] === 'login') {
            // Handle login
            require_once __DIR__ . '/controller/loginController.class.php';
            $loginController = new LoginController();
            $loginController->index();
        } elseif ($_POST['gumb'] === 'registracija') {
            // Handle registration
            require_once __DIR__ . '/controller/registracijaController.class.php';
            $registracijaController = new RegistracijaController();
            $registracijaController->index();
        }
    } else {
        routeRequest();
    }
} else {
    // Handle GET request
    routeRequest();
}

// Provjeravamo jel postavljen cookie za username, ako je znaci da je user ulogiran i prikazujemo mu pripadni menu
if (isset($_COOKIE["username"])) {
    $controllerName = $con . 'Controller';
    require_once __DIR__ . '/controller/' . $controllerName . '.class.php';
    $c = new $controllerName;
    $c->$action();
} else {
    // Ako u njemu nema tražene akcije, stavi da se traži akcija login
    $controllerName = 'loginController';
    $action = 'index';
    require_once __DIR__ . '/controller/' . $controllerName . '.class.php';
    $c = new $controllerName;
    $c->$action();
}

// Pozovi odgovarajuću akciju
$tmp = $c->$action();

// Ako je $tmp=1, znaci login je uspjesan, postavimo cookie za username
if ($tmp == 1) {
    setcookie('username', $_POST["username"], time() + (124123 * 3123));
}
*/