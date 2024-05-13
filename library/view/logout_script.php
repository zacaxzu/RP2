<?php

//session_start();
var_dump($_SERVER['PHP_SELF']);
// Check if logout button is clicked
if (isset($_SESSION['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page
    header("Location: zadatak5_html.php");
    exit;
}

?>