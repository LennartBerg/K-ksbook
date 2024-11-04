<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();
$recipeController->updateRecipe($_POST['recipeID'], $_POST['nameRecipe'], $_POST['instructions'], $_POST['ingredients'], $_POST['worktime'], $_POST['meal'], $_POST['diet']);
$recipe = $recipeController->showRecipeById($_POST['recipeID']);
$comments = $recipeController->showComments($_POST["recipeID"]);
$author = $recipeController->showAuthor($recipe->getUserID());

if (isset($_SESSION['userID'])) {
    $rating = $recipeController->showRating($_POST["recipeID"], $_SESSION['userID']);
}


require_once $abs_path . "/php/view/viewRecipe.php";
?>