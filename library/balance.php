<?php

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

require_once __DIR__ . '/controller/' . $controllerName . '.class.php';

$c = new $controllerName;

// Provjeravamo jel postavljen cookie za username, ako je znaci da je user ulogiran i prikazujemo mu pripadni menu
if (isset($_COOKIE["username"])) {
    require_once __DIR__ . '/controller/' . $controllerName . '.class.php';
    $c = new $controllerName;
    $c->$action();
} else {
    // Ako u njemu nema tražene akcije, stavi da se traži akcija login
    $controllerName = 'loginController';
    $action = 'index';
    require_once __DIR__ . '/controller/' . $controllerName . '.class.php';
    $c = new $controllerName;
}

$c->$action();

// Pozovi odgovarajuću akciju
$tmp = $c->$action();

// Ako je $tmp=1, znaci login je uspjesan, postavimo cookie za username
if ($tmp == 1) {
    setcookie('username', $_POST["username"], time() + (124123 * 3123));
}