<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/IndexController.php";
$controller = new IndexController();

$recipes = $controller->request();

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 4;
$recipes = array_slice($recipes, $offset, $limit);

$response = [];
foreach ($recipes as $recipe) {
    $response[] = [
        'recipeID' => $recipe->getRecipeID(),
        'userID' => $recipe->getUserID(),
        'name' => htmlspecialchars($recipe->getName()),
        'ingredients' => htmlspecialchars($recipe->getIngredients()),
        'instructions' => htmlspecialchars($recipe->getInstructions()),
        'mealType' => htmlspecialchars($recipe->getMealType()),
        'workTime' => htmlspecialchars($recipe->getWorkTime()),
        'dietType' => htmlspecialchars($recipe->getDietType()),
        'creationDate' => htmlspecialchars($recipe->getCreationDate()),
        'averageRating' => htmlspecialchars($recipe->getAverageRating()),
        'ratings' => htmlspecialchars($recipe->getRatings()),
        'picturePath' => htmlspecialchars($recipe->getPicturePath()),
        'username' => htmlspecialchars($userList->getUserByID($recipe->getUserID())->getUsername())
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
