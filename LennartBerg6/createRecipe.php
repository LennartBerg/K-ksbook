<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

if (!$_SESSION['isLoggedIn']) {
    header("Location: logIn.php");
    $_SESSION["message"] = "login_first";
    exit;
}

require_once $abs_path . "/php/view/createRecipe.php";