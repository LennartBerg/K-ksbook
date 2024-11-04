<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require "path.php";
}

require_once $abs_path . "/php/controller/UserController.php";
$userController = new UserController();

$userController->verifyAccount($_POST["code"]);
