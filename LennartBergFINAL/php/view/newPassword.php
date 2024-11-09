<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($abs_path)) {
    require "path.php";

}
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = "Log In";
require $abs_path . '/php/include/head.php';

?>
<link rel="stylesheet" type="text/css" href="./assets/css/logIn.css">
<link rel="stylesheet" type="text/css" href="./assets/css/confirm.css">
</head>
<body>
<?php
require './php/include/nav.php';
?>
<main>
    <section>
        <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "new_user_not_activated"): ?>
            <p class="GreenNotification">
                You have successfully registered. Please check your email to activate your account.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_code"): ?>
            <p class="RedNotification">
                The code you entered is invalid. Please try again.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_password_reset"): ?>
            <p class="RedNotification">
                The passwords you entered do not match. Please try again.
            </p>
        <?php endif;
        unset($_SESSION["message"]);
        ?>
        <div class="acitvationContainer">
            <h1>Reset Your Password</h1>
            <p>You will soon (1 minute later) receive a mail containing your personal activation code. If you already
                received it, enter it
                below. If you forget to activate your account, you can request a new activation code by just
                re-requesting
                with the same mail address. </p>
            <p>You can find your activation code in this <a target="_blank"
                                                            href="<?= './php/controller/' . $_SESSION['filepath'] ?>">file</a>
            </p>
            <form action="newPasswordAction.php" method="POST">
                <div class="registry-success-form">
                    <label for="code">Activation Code:</label><br> <br>
                    <input type="text" id="code" name="code" placeholder="Enter the code" required> <br> <br>
                    <label for="password">New Password:</label><br> <br>
                    <input type="password" id="password" name="password" placeholder="Enter your new password" required>
                    <br> <br>
                    <label for="passwordRepeat">Repeat New Password:</label><br> <br>
                    <input type="password" id="passwordRepeat" name="passwordRepeat"
                           placeholder="Repeat your new password"
                           required> <br> <br>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="button">Submit</button>
                </div>
            </form>
        </div>
    </section>
</main>
<br>
<?php
require './php/include/foot.php';
unset($_SESSION["message"])
?>
</body>
</html>