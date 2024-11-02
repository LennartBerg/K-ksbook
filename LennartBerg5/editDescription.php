<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
if (isset($_POST['description'])) {
    $userController->changeDescription($_POST['description']);
} else {
    $_SESSION["message"] = "no_description";
    header("Location: /profil.php");

}

