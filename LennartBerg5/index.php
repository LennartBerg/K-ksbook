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

require_once $abs_path . "/php/view/index.php";
?>
