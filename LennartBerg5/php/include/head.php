<head>
    <link rel="shortcut icon" href="assets/icons/TabIcon.ico" type="image/x-icon">
    <!-- quelle: https://icon-icons.com/icon/cooked-food-meal-cooking-cuisine-dinner-healthy-meat/140888 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (!empty($pageTitle)) {
            echo $pageTitle;
        } ?></title>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($abs_path)) {
    require_once "../../path.php";
}
