<?php
// Load necessary files
require_once 'controller/loginController.php';

// Create instance of LoginController and call appropriate method
$loginController = new loginController();
$loginController->index();
