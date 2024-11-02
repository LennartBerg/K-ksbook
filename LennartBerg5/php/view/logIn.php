<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($abs_path)) {
    require_once "path.php";

}
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = "Log In";
require $abs_path . '/php/include/head.php';
$form_logIn = $_SESSION['Form_logIn'] ?? [];

?>
<link rel="stylesheet" type="text/css" href="./assets/css/logIn.css">
</head>
<body>
<?php
require './php/include/nav.php';
?>
<div class="main">
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "You are not logged in."): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            You are not logged in. Please log in to continue.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            An internal error occurred.
            Please try again or contact the administrator.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_entry"): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            Error calling the page: Necessary parameters are missing!
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_login"): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            Invalid login data. Please try again.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "new_user"): ?>
        <h1>Log In</h1>
        <p class="GreenNotification">
            You have successfully registered. Please log in.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login_first"): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            You have to log in first before creating recipes. If you don't have an Accout yet, you can register <a
                    href="register.php">here</a>.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "Please log in to view your profile."): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            Please log in to view your profile.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login_first_favorites"): ?>
        <h1>Log In</h1>
        <p class="RedNotification">
            You have to log in first to view your favorites.
        </p>
    <?php else : ?>
        <h1>Welcome Back!</h1>
    <?php endif;
    unset($_SESSION["message"]);
    ?>
    <div>
        <form action="logInAction.php" method="post">
            <label for="loginUsername">Email:
                <input type="email" id="loginUsername" maxlength="100" name="email" required
                       placeholder="mail@provider.com"
                       value="<?php echo htmlspecialchars($form_logIn['email'] ?? ''); ?>">
            </label>
            <label for="loginPassword">Password:
                <input type="password" id="loginPassword" maxlength="1000" name="password" placeholder="Passwort"
                       required>
            </label>
            <button class="button" type="submit">log in</button>
        </form>
    </div>
</div>
<br>
<?php
require './php/include/foot.php';
unset($_SESSION["message"])
?>
</body>
</html>
