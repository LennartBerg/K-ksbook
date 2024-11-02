<header>
    <img src="assets/icons/TabIcon.ico" alt="TabIcon" class="headerIcon">
    <!-- quelle: https://icon-icons.com/icon/cooked-food-meal-cooking-cuisine-dinner-healthy-meat/140888 -->
    <div class="headerText">
        <h1>Köksbook</h1>
        <h2>Find, Cook, Enjoy!</h2>
    </div>
    <div class="block"></div>
</header>
<nav class="navigation">
    <ul class="menu dropdown">
        <li><a href="index.php">Home</a></li>
        <li><a href="profil.php?userID=<?php
            if (isset($_SESSION['userID'])) echo urlencode($_SESSION['userID']);
            else echo "";
            ?>">Profile</a></li>
        <li><a href="createRecipe.php">Create Recipe</a></li>
        <?php if (isset($_SESSION["isLoggedIn"]) && $_SESSION['isLoggedIn']): ?>
            <li><a href="logout.php">Log Out</a></li>
        <?php else: ?>
            <li><span>Log In/ Register</span>
                <ul>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="logIn.php">Log In</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <!-- <li><a href="favorites.php">Favorites</a></li> -->
    </ul>
</nav>
