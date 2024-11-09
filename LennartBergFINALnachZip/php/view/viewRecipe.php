<?php
if (!isset($abs_path)) {
    require_once "path.php";
}


require_once $abs_path . "/php/model/userModel/UserList.php";

$userList = UserList::getInstance();


$recipeID = $recipe->getRecipeID();
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
}

$pageTitle = "View Recipe";
?>

<!DOCTYPE html>
<html lang="en">
<?php require './php/include/head.php';
?>
<link rel="stylesheet" href="./assets/css/friedTofu.css">
</head>
<body>
<?php require './php/include/nav.php'; ?>

<main>
    <section>
        <div class="RecipeShortInfo">
            <div class="text-content">
                <h1>
                    <a href="viewRecipe.php?recipeID=<?php echo urlencode($recipe->getRecipeID()); ?>"><?= htmlspecialchars($recipe->getName()) ?> </a>
                </h1>
                <a href="profil.php?userID=<?= $recipe->getUserID(); ?>"><span><?= "BY " . (htmlspecialchars($author)) ?></span></a>
                <span><?= $recipe->getCreationDate() ?></span>
                <div class="iconAndText">
                    <img src="./assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                    <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                    <span>
                    <?php if ($recipe->getAverageRating() > 5): ?>
                        <span id="averageRating">-</span>/5
                    <?php else: ?>
                        <span id="averageRating"><?= htmlspecialchars($recipe->getAverageRating()); ?></span>/5
                    <?php endif; ?>
                    <span id="reviewCount">(<?= htmlspecialchars($recipe->getRatings()); ?> reviews)</span>
                </span>
                    <br>
                </div>
                <div class="iconAndText">
                    <img src="./assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                    <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                    <span><?php echo htmlspecialchars($recipe->getWorkTime()); ?> minutes</span> <br>
                </div>
            </div>
            <div>
                <a href="viewRecipe.php?recipeID=<?php echo $recipe->getRecipeID(); ?>">
                    <img class="previewPicture"
                         src="<?php echo $recipe->getPicturePath(); ?>"
                         alt="<?= "Picture of " . htmlspecialchars($recipe->getName()); ?>">
                </a>
            </div>
        </div>
        <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "comment_deleted"): ?>
            <div class="padding">
                <div class="information">
                    <p class="GreenNotification">
                        Comment deleted!
                    </p>
                </div>
            </div>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "comment_added"): ?>
            <div class="padding">
                <div class="information">
                    <p class="GreenNotification">
                        Comment added!
                    </p>
                </div>
            </div>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "review_deleted"): ?>
            <div class="padding">
                <div class="information">
                    <p class="GreenNotification">
                        Review deleted!
                    </p>
                </div>
            </div>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "recipe_updated"): ?>
            <div class="padding">
                <div class="information">
                    <p class="GreenNotification">
                        Recipe updated!
                    </p>
                </div>
            </div>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "not_owner"): ?>
            <div class="padding">
                <div class="information">
                    <p class="RedNotification">
                        You are not the owner of this recipe!
                    </p>
                </div>
            </div>
        <?php endif;
        unset($_SESSION["message"]);
        if (isset($_SESSION['id'])): ?>
            <div class="center">
                <h1>Rate this recipe:</h1>
                <div class="card">
                    <button class="star <?php if (htmlspecialchars($rating) == 5) echo ', selected' ?>" data-value="5"
                            onclick="submitRating(5, <?= htmlspecialchars($recipeID) ?>)"
                            aria-label="5th Star">★
                    </button>
                    <button class="star <?php if (htmlspecialchars($rating) >= 4) echo ', selected' ?>" data-value="4"
                            onclick="submitRating(4, <?= htmlspecialchars($recipeID) ?>)"
                            aria-label="4th Star">★
                    </button>
                    <button class="star <?php if (htmlspecialchars($rating) >= 3) echo ', selected' ?>" data-value="3"
                            onclick="submitRating(3, <?= htmlspecialchars($recipeID) ?>)"
                            aria-label="3rd Star">★
                    </button>
                    <button class="star <?php if ($rating >= 2) echo ', selected' ?>" data-value="2"
                            onclick="submitRating(2, <?= htmlspecialchars($recipeID) ?>)"
                            aria-label="2nd Star">★
                    </button>
                    <button class="star <?php if ($rating >= 1) echo ', selected' ?>" data-value="1"
                            onclick="submitRating(1, <?= htmlspecialchars($recipeID) ?>)"
                            aria-label="1st Star">★
                    </button>

                </div>
                <noscript>
                    <form class="rating" action="./addRating.php" method="post">
                        <input type="hidden" name="recipeID" value="<?= htmlspecialchars($recipe->getRecipeID()) ?>">
                        <label for="rating">Rate this recipe:</label>
                        <select class="select-multi" name="rating" id="rating" required>
                            <option value="1" <?php if (htmlspecialchars($rating == 1)) echo 'selected'; ?>>1 Star
                            </option>
                            <option value="2" <?php if (htmlspecialchars($rating == 2)) echo 'selected'; ?>>2 Stars
                            </option>
                            <option value="3" <?php if (htmlspecialchars($rating == 3)) echo 'selected'; ?>>3 Stars
                            </option>
                            <option value="4" <?php if (htmlspecialchars($rating == 4)) echo 'selected'; ?>>4 Stars
                            </option>
                            <option value="5" <?php if (htmlspecialchars($rating == 5)) echo 'selected'; ?>>5 Stars
                            </option>
                        </select>
                        <?php if (htmlspecialchars($rating != null)): ?>
                            <button id="Editbutton" type="submit">Update Rating</button>
                        <?php else: ?>
                            <button id="Editbutton" type="submit">Rate</button>
                        <?php endif; ?>
                    </form>
                </noscript>
                <?php if ($recipe->getUserID() == $_SESSION["id"]): ?>
                    <form action="./editRecipe.php" method="post" class="buttonInside">
                        <input type="hidden" name="recipeID" value="<?= htmlspecialchars($recipe->getRecipeID()) ?>">
                        <button id="Editbutton" type="submit">Edit Recipe</button>
                    </form>
                    <form action="./deleteRecipe.php" class="buttonInside" method="post"
                          onsubmit="return confirmDeletion()">
                        <input type="hidden" name="recipeID" value="<?= htmlspecialchars($recipe->getRecipeID()) ?>">
                        <button class="ButtonButton" type="submit">Delete Recipe</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        </div>
        <div class="padding">
            <div class="information">
                <div class="ingredients">
                    <h1>Mealtype and Diettype</h1>
                    <p class="ingredientstext" id="mealtype">
                        <?= htmlspecialchars($recipe->getMealType()) ?>, <?= htmlspecialchars($recipe->getDietType()) ?>
                    </p>
                    <h1>Ingredients</h1>
                    <p class="ingredientstext">
                        <?= htmlspecialchars($recipe->getIngredients()) ?>
                    </p>
                </div>
                <div class="instructions">
                    <h1>Instructions</h1>
                    <p class="instructionstext">
                        <?= htmlspecialchars($recipe->getInstructions()) ?>
                </div>
                <div class="reviews">
                    <h1 class="reviewTitle">Reviews</h1>
                    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "review_added"): ?>
                        <p>
                            Review added!
                        </p>
                    <?php endif;
                    if ($comments != null) {
                        foreach ($comments as $comment): ?>
                            <div class="review">
                                <p class="reviewInfo">By:<a
                                            href="profil.php?userID=<?= urlencode($comment->getUserID()) ?>"><?= htmlspecialchars($userList->getUserByID($comment->getUserID())->getUsername()); ?></a> <?= htmlspecialchars($comment->getCreationDate()); ?>
                                </p>
                                <p><?= htmlspecialchars($comment->getText()); ?></p>
                                <?php if (isset($_SESSION['id']) && $comment->getUserID() == $_SESSION["id"]): ?>
                                    <form action="./deleteReview.php" method="post" onsubmit="return confirmDeletion()">
                                        <input type="hidden" name="commentID"
                                               value="<?= htmlspecialchars($comment->getCommentID()); ?>">
                                        <button class="button" type="submit"><b>Delete</b></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach;
                    } else {
                        echo "<p>No reviews found</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="newReview">
                <form action="./addReview.php" method="post">
                    <input type="hidden" name="recipeID" value="<?= htmlspecialchars($recipe->getRecipeID()) ?>">
                    <label for="reviewField">Write Review:</label>
                    <textarea required name="text" id="reviewField" minlength="15" maxlength="350"></textarea>
                    <button class="button" type="submit"><b>Publish</b></button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php require './php/include/foot.php'; ?>
<script src="./viewRecipe.js"></script>
<script src="./review.js"></script>
</body>
</html>

