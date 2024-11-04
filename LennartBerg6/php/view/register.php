<!DOCTYPE html>
<html lang="en">
<?php
$pageTitle = "Register";
require './php/include/head.php';
?>
<link rel="stylesheet" type="text/css" href="./assets/css/register.css">
</head>
<body>
<?php
require './php/include/nav.php';
?>
<div class="main">
    <h1> Register</h1>
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p class="RedNotification">
            An internal error occurred.
            Please try again or contact the administrator.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_entry_register"): ?>
        <p class="RedNotification">
            Error calling the page: Necessary parameters are missing!
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_register"): ?>
        <p class="RedNotification">
            Invalid registration data. Please try again.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "existing_useremail"): ?>
        <p class="RedNotification">
            A user with this email already exists.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "existing_username"): ?>
        <p class="RedNotification">
            A user with this name already exists.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_register_password"): ?>
        <p class="RedNotification">
            The passwords do not match.
        </p>
    <?php endif;
    unset($_SESSION["message"]);
    ?>
    <br>
    <div class="RegisterBox">
        <form class="createForm" action="registerAction.php" method="post">
            <label for="Email">Email:<br>
                <input id="Email" type="email" name="email" placeholder="mail@provider.com"
                       maxlength="100" required
                       value="<?= htmlspecialchars($_SESSION['Form_Register']["email"] ?? '') ?>">
            </label> <br>
            <label for="password">Password:<br>
                <input id="password" type="password" name="password" minlength="7" maxlength="30"
                       placeholder="Passwort" required>
            </label> <br>
            <label for="password_repeat">Repeat Password:<br>
                <input id="password_repeat" type="password" name="password_repeat" minlength="7" maxlength="30"
                       placeholder="Passwort" required>
            </label> <br>
            <label for="name">Name:<br>
                <input maxlength="15" id="name" type="text" name="name" placeholder="Mustermann"
                       required value="<?= htmlspecialchars($_SESSION['Form_Register']["name"] ?? '') ?>">
            </label> <br>
            <label for="description">Description:<br>
                <textarea rows="5" minlength="30" id="description" name="description"
                          maxlength="10000"
                          placeholder="Description"><?= htmlspecialchars($_SESSION['Form_Register']["description"] ?? '') ?></textarea>
            </label> <br>
            <label>
                <input type="checkbox" required>I hereby accept the <a href="../../termsOfUse.php">Terms of Use</a> and
                the
                <a href="../../PrivacyPolicy.php">Privacy Policy</a> of Köksbook.
            </label> <br>
            <button class="select-button" type="submit">Register</button>
        </form>
    </div>
</div>
<?php
require './php/include/foot.php';
?>
</body>
</html>
