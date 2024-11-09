<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
    require_once "path.php";
}

function fetchFromAPI($url)
{
    $response = file_get_contents($url);
    return json_decode($response, true);
}

if (isset($_POST['categoryRandom']) && isset($_POST['areaRandom'])) {
    $category = $_POST['categoryRandom'];
    $area = $_POST['areaRandom'];
    $_SESSION['category'] = $category;
    $_SESSION['area'] = $area;

    $filteredMeals = [];


    if ($category === "all" && $area === "all") {
        $_SESSION['filteredMeal'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/random.php");
        header("Location: ./index.php");
        exit();
    }
    if ($category && $category !== "all") {
        $filteredMeals = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/filter.php?c=" . urlencode($category));
        if ($area == "all") {
            $filteredMeals = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/filter.php?c=" . urlencode($category));
            $randomIndex = array_rand($filteredMeals['meals']);
            $meal = $filteredMeals['meals'][$randomIndex];
            $_SESSION['filteredMeal'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($meal['idMeal']));
            unset($filteredMeals);
            unset($areaMeals);
            header("Location: ./index.php");
            exit();
        }
    }
    if ($area && $area !== "all") {
        $areaMeals = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/filter.php?a=" . urlencode($area));
        if (!empty($filteredMeals)) {
            $filteredMeals['mealsintersect'] = array_filter($filteredMeals['meals'], function ($meal) use ($areaMeals) {
                return in_array($meal['idMeal'], array_column($areaMeals['meals'], 'idMeal'));
            });
            if (!empty($filteredMeals['mealsintersect'])) {
                $randomIndex = array_rand($filteredMeals['mealsintersect']);
                $meal = $filteredMeals['mealsintersect'][$randomIndex];
                $_SESSION['filteredMeal'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($meal['idMeal']));
                unset($filteredMeals);
                unset($areaMeals);
                header("Location: ./index.php");
                exit();
            } else {
                $_SESSION['message'] = "tooSpecific";
                $randomIndex = array_rand($filteredMeals['meals']);
                $meal = $filteredMeals['meals'][$randomIndex];
                $_SESSION['filteredMeal'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($meal['idMeal']));
                unset($filteredMeals);
                unset($areaMeals);
                header("Location: ./index.php");
                exit();
            }
        } else {
            $filteredMeals = $areaMeals;
            $randomIndex = array_rand($filteredMeals['meals']);
            $meal = $filteredMeals['meals'][$randomIndex];
            $_SESSION['filteredMeal'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($meal['idMeal']));
            unset($filteredMeals);
            unset($areaMeals);
            header("Location: ./index.php");
            exit();
        }
    }
    $_SESSION['filteredMeals'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/random.php");
    $_SESSION['message'] = "empty";
} else {
    $_SESSION['filteredMeals'] = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/random.php");
    $_SESSION['message'] = "random";
}

header("Location: ./index.php");
exit();
?>
