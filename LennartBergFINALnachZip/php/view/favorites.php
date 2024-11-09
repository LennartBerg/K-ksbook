<!DOCTYPE html>
<?php
$pageTitle = "Favorites";
?>
<html lang="en">
<?php require './php/include/head.php'; ?>
<link rel="stylesheet" type="text/css" href="./assets/css/favorites.css">
</head>
<body>
<?php require './php/include/nav.php'; ?>
<main>
    <section>
        <h1> Your Favorites</h1>
        <div class="RecipePreviewLayout">
            <?php foreach ($favoriteRecipes as $recipe): ?>
                <div>
                    <div class="RecipePreview">
                        <div class="RecipePictureContainer">
                            <a href="viewRecipe.php">
                                <img class="RecipePicture"
                                     src="../model/recipeModel/uploadedRecipePictures/<?= $recipe->getPicture() ?>"
                                     alt="Picture of <?= $recipe->getName() ?>">
                            </a>
                        </div>
                        <h2><a href="viewRecipe.php"><?= $recipe->getName() ?></a></h2>
                        <span><a href="profil.php"><?= $recipe->getAuthor() ?></a></span> <br>
                        <div class="iconAndText">
                            <img src="../../assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                            <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                            <span> <?= $recipe->getRating() ?>/5 (<?= $recipe->getNumberOfRatings() ?> reviews)</span>
                            <br>
                        </div>
                        <div class="iconAndText">
                            <img src="../../assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                            <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                            <span><?= $recipe->getWorkTime() ?> minutes</span> <br>
                        </div>
                        <button class="select-button" type="submit">Remove from Favorites</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <div>
                <div class="RecipePreview">
                    <div class="RecipePictureContainer">
                        <a href="viewRecipe.php">
                            <img class="RecipePicture" src="../model/recipeModel/uploadedRecipePictures/friedTofu.png"
                                 alt="Picture of Fried Tofu">
                        </a>
                    </div>
                    <h2><a href="viewRecipe.php">Fried Tofu</a></h2>
                    <span><a href="profil.php">Lennart Berg</a></span> <br>
                    <div class="iconAndText">
                        <img src="../../assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                        <span> 4.5/5 (34 reviews)</span> <br>
                    </div>
                    <div class="iconAndText">
                        <img src="../../assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                        <span>15 minutes</span> <br>
                    </div>
                    <button class="select-button" type="submit">Remove from Favorites</button>
                </div>
            </div>
            <div>
                <div class="RecipePreview">
                    <div class="RecipePictureContainer">
                        <a href="viewRecipe.php">
                            <img class="RecipePicture" src="../model/recipeModel/uploadedRecipePictures/friedTofu.png"
                                 alt="Picture of Fried Tofu">
                        </a>
                    </div>
                    <h2><a href="viewRecipe.php">Fried Tofu</a></h2>
                    <span><a href="profil.php">Lennart Berg</a></span> <br>
                    <div class="iconAndText">
                        <img src="../../assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                        <span> 4.5/5 (34 reviews)</span> <br>
                    </div>
                    <div class="iconAndText">
                        <img src="../../assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                        <span>15 minutes</span> <br>
                    </div>
                    <button class="select-button" type="submit">Remove from Favorites</button>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
require './php/include/foot.php';
?>
</body>
</html>
