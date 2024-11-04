<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/IndexController.php";


$indexController = new IndexController();
$recipes = $indexController->request();

isset($_GET['full']) ? $full = true : $full = false;

if (!$full) {
    $limitStart = 3;
    $recipes = array_slice($recipes, 0, $limitStart);
}

function fetchFromAPI($url)
{
    $response = file_get_contents($url);
    return json_decode($response, true);
}

$categories = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/list.php?c=list");
$areas = fetchFromAPI("https://www.themealdb.com/api/json/v1/1/list.php?a=list");

require_once $abs_path . "/php/view/index.php";
?>
