<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();
$_SESSION['recipeID'] = $_POST['recipeID'];

$recipe = $recipeController->showRecipeById($_POST['recipeID']);
$comments = $recipeController->showComments($_POST["recipeID"]);
$author = $recipeController->showAuthor($recipe->getUserID());

require_once $abs_path . "/php/view/editRecipe.php";
?>