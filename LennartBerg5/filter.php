<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();

$_SESSION['filter']['meal-type-filter'] = htmlspecialchars($_GET['meal-type-filter']);
$_SESSION['filter']['work-time-filter'] = htmlspecialchars($_GET['work-time-filter']);
$_SESSION['filter']['diet-style-filter'] = htmlspecialchars($_GET['diet-style-filter']);
$_SESSION['filter']['rating-filter'] = htmlspecialchars($_GET['rating-filter']);


header("Location: ./index.php");
exit();

?>
