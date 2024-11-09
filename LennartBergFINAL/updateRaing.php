<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/RecipeController.php";

$recipeController = new RecipeController();

$response = ["success" => false];

if (isset($_POST['recipeID'], $_POST['rating']) && isset($_SESSION['id'])) {
    $recipeID = (int)$_POST['recipeID'];
    $rating = (int)$_POST['rating'];
    $userID = $_SESSION['id'];

    if ($rating >= 1 && $rating <= 5) {
        $recipeController->addRating($recipeID, $userID, $rating);
        $response["success"] = true;
    }
}

header("Content-Type: application/json");
echo json_encode($response);