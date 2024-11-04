<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/RecipeController.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($_SESSION['userID'], $data['recipeID'], $data['rating'])) {
    $recipeID = $data['recipeID'];
    $userID = $_SESSION['userID'];
    $rating = $data['rating'];

    $recipeController = new RecipeController();
    $recipeController->addRating($recipeID, $userID, $rating);

    $recipeController = new RecipeController();
    $recipe = $recipeController->getRecipeByID($recipeID);
    
    echo json_encode([
        'success' => true,
        'newAverageRating' => $recipe->getAverageRating(),
        'newReviewCount' => $recipe->getRatings(),
        'message' => 'Rating updated successfully!'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
exit();
?>