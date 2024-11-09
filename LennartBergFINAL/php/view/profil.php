<!DOCTYPE html>
<?php
$pageTitle = "Profile";
?>
<html lang="en">
<?php require './php/include/head.php'; ?>
<link rel="stylesheet" type="text/css" href="./assets/css/profil.css">
</head>
<body>
<?php require './php/include/nav.php'; ?>
<main>
    <section>
        <h1><?= htmlspecialchars($user->getUsername()) . "'s Profile"; ?> </h1>
        <div class="profile">
            <h2>Profile Details</h2>
            <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "description_updated"): ?>
                <p class="GreenNotification">Your Description was updated!</p>
            <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "not_owner"): ?>
                <p class="RedNotification">You are not the owner of this profile!</p>
            <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "no_description"): ?>
                <p class="RedNotification">No description was provided!</p>
            <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "not_owner_delete_user"): ?>
                <p class="RedNotification">You are not the owner of this profile! You may not delete other users.</p>
            <?php endif;
            unset($_SESSION["message"]) ?>
            <p><strong>Email:</strong> <span id="email"> <?= htmlspecialchars($user->getEmail()); ?>  </span></p>
            <p><strong>Member since:</strong> <span
                        id="location"> <?= htmlspecialchars($user->getCreationDate()); ?> </span></p>
            <h2>Description</h2>
            <?php if (isset($_SESSION['userID']) && $_SESSION["userID"] == $user->getUserID()): ?>
                <form method="post" class="UpdateDescription-Form" action="editDescription.php">
                    <label for="description"><br>
                        <textarea rows="5" minlength="30" id="description" name="description"
                                  placeholder="Description"
                                  required><?= htmlspecialchars($user->getDescription()); ?></textarea>
                    </label>
                    <input type="hidden" name="userID" id="userID" value="<?= htmlspecialchars($userID) ?>">
                    <button type="submit" class="button">Change Description</button>
                </form>
                <form action="./deleteUser.php?userID=<?php echo urlencode($userID) ?>" class="buttonInside"
                      method="post"
                      onsubmit="return confirmDeletion()">
                    <button class="deleteUserButton" type="submit">Delete Account</button>
                </form>
            <?php else: ?>
                <p><?= htmlspecialchars($user->getDescription()); ?></p>
            <?php endif; ?>
        </div>

        <h2><?= htmlspecialchars($user->getUsername()); ?>'s Created Recipes</h2>
        <div class="RecipePreviewLayout">

            <?php foreach ($recipes as $recipe): ?>
                <div>
                    <div class="RecipePreview">
                        <div class="RecipePictureContainer">
                            <a href="viewRecipe.php?recipeID=<?php echo urlencode($recipe->getRecipeID()); ?>">
                                <img class="RecipePicture"
                                     src="<?php echo htmlspecialchars($recipe->getPicturePath()); ?>"
                                     alt="Picture of <?= htmlspecialchars($recipe->getName()); ?>">
                            </a>
                        </div>
                        <h2>
                            <a href="viewRecipe.php?recipeID=<?php echo urlencode($recipe->getRecipeID()); ?>"><?= htmlspecialchars($recipe->getName()); ?></a>
                        </h2>
                        <span><a href="profil.php?userID=<?= urlencode($recipe->getUserID()); ?>"> <?= htmlspecialchars($user->getUsername()); ?></a></span>
                        <br>
                        <div class="iconAndText">
                            <img src="./assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                            <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                            <span> <?php if (htmlspecialchars($recipe->getAverageRating()) > 5) {
                                    echo "-";
                                } else
                                    echo htmlspecialchars($recipe->getAverageRating()); ?>/5 (<?php echo htmlspecialchars($recipe->getRatings()); ?> reviews)</span>
                            <br>
                        </div>
                        <div class="iconAndText">
                            <img src="./assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                            <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                            <span><?php echo htmlspecialchars($recipe->getWorkTime()); ?> minutes</span> <br>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<script src="./deleteUser.js"></script>
<?php
require './php/include/foot.php';
?>
</body>
</html>
