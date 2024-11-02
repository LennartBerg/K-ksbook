<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}


require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();
$recipe = $recipeController->showRecipe();
$comments = $recipeController->showComments($_GET["recipeID"]);
$author = $recipeController->showAuthor($recipe->getUserID());
if (isset($_SESSION['userID'])) {
    $rating = $recipeController->showRating($_GET["recipeID"], $_SESSION['userID']);
}

require_once $abs_path . "/php/view/viewRecipe.php";
?>