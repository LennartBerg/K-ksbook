<!DOCTYPE html>
<html lang="en">
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($abs_path)) {
    require_once "path.php";
}
$pageTitle = "Legal Notice";
require $abs_path . "/php/include/head.php";
?>
<link rel="stylesheet" type="text/css" href="./assets/css/legalNotice.css">
</head>
<body>
<?php
require './php/include/nav.php';
?>
<main>
    <h1>Legal Notice</h1>
    <p>Lennart Berg<br/>
        Musterstra&szlig;e<br/>
        Mustergebäude 44<br/>
        90210 Musterstadt</p>
    <h2>Contact</h2>
    <p>Telefon: +49 (0) 123 44 55 66<br/>
        Telefax: +49 (0) 123 44 55 99<br/>
        E-Mail: mustermann@musterfirma.de</p>
    <p>Source: <a href="https://www.e-recht24.de/impressum-generator.html">https://www.e-recht24.de/impressum-
            generator.html</a></p>
    </div>
    <?php
    require './php/include/foot.php';
    ?>
</body>
</html>
