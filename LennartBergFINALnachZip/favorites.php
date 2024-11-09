<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require "path.php";
}

if (!isset($_SESSION['userID'])) {
    header("Location: logIn.php");
    $_SESSION["message"] = "login_first_favorites";
    exit();
}

require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$favoriteRecipes = $userController->getFavorites($_SESSION['userID']);

require_once $abs_path . "/php/view/favorites.php";
