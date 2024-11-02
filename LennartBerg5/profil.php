<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";
require_once $abs_path . "/php/controller/UserController.php";

$recipeController = new RecipeController();
$userController = new UserController();

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];
    $recipes = $recipeController->showRecipesbyUserID($userID);
    $user = $userController->showUserById($userID);
} else {
    header("Location: logIn.php");
    $_SESSION["message"] = "Please log in to view your profile.";
}

require_once $abs_path . "/php/view/profil.php";

?>