<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();
$recipeID = $_POST['recipeID'];
$userID = $_SESSION['userID'];
$rating = $_POST['rating'];
$recipeController->addRating($recipeID, $userID, $rating);


$_GET["recipeID"] = $recipeID;
$recipe = $recipeController->showRecipe();
$comments = $recipeController->showComments($recipeID);
$author = $recipeController->showAuthor($recipe->getUserID());

header("Location: ./viewRecipe.php?recipeID=$recipeID");
exit();
?>