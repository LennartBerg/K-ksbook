<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}

$pageTitle = "Home";
?>

<!DOCTYPE html>
<html lang="en">
<?php require $abs_path . '/php/include/head.php';
require_once $abs_path . "/php/controller/IndexController.php";
?>
<link rel="stylesheet" type="text/css" href="./assets/css/index.css">
</head>
<body>
<?php require './php/include/nav.php'; ?>
<div class="main">
    <h1>Explore new Recipes!</h1>
    <br>
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p class="RedNotification">
            An internal error occurred.
            Please try again or contact the administrator.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "logout"): ?>
        <p class="GreenNotification">
            You have been logged out.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login"): ?>
        <p class="GreenNotification">
            You have been logged in.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "recipe_deleted"): ?>
        <p class="GreenNotification">
            Recipe deleted!
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "recipe_created"): ?>
        <p class="GreenNotification">
            Recipe created!
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p class="RedNotification">
            An internal error occurred.
            Please try again or contact the administrator.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "recipe_not_found"): ?>
        <p class="RedNotification">
            The recipe you are looking for does not exist.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
        <p class="RedNotification">
            The user you are looking for does not exist.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "comment_not_found"): ?>
        <p class="RedNotification">
            The comment you are looking for does not exist.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_entry_id"): ?>
        <p class="RedNotification">
            The entry you are looking for does not exist.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "recipe_not_found_delete"): ?>
        <p class="RedNotification">
            The recipe wanted to delete does not exist.
        </p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_deleted"): ?>
        <p class="GreenNotification">
            User deleted! All your recipes, ratings and comments have been deleted as well. You have been logged out,
            too.
        </p>
    <?php endif;
    unset($_SESSION["message"]);
    ?>
    <div class="filters">
        <form action="filter.php" method="GET">
            <?php
            // Retrieve filter values from the session or set default values
            $mealTypeFilter = isset($_SESSION['filter']['meal-type-filter']) ? $_SESSION['filter']['meal-type-filter'] : 'all';
            $workTimeFilter = isset($_SESSION['filter']['work-time-filter']) ? $_SESSION['filter']['work-time-filter'] : '0';
            $dietStyleFilter = isset($_SESSION['filter']['diet-style-filter']) ? $_SESSION['filter']['diet-style-filter'] : 'all';
            $ratingFilter = isset($_SESSION['filter']['rating-filter']) ? $_SESSION['filter']['rating-filter'] : '0';
            ?>
            <div>
                <label for="meal-type-filter">Meal Type:</label>
                <select class="select-multi" name="meal-type-filter" id="meal-type-filter">
                    <option value="all" <?php if ($mealTypeFilter == 'all') echo 'selected'; ?>>All</option>
                    <option value="breakfast" <?php if ($mealTypeFilter == 'breakfast') echo 'selected'; ?>>Breakfast
                    </option>
                    <option value="lunch" <?php if ($mealTypeFilter == 'lunch') echo 'selected'; ?>>Lunch</option>
                    <option value="dinner" <?php if ($mealTypeFilter == 'dinner') echo 'selected'; ?>>Dinner</option>
                    <option value="snack" <?php if ($mealTypeFilter == 'snack') echo 'selected'; ?>>Snack</option>
                    <option value="drink" <?php if ($mealTypeFilter == 'drink') echo 'selected'; ?>>Drink</option>
                </select>
            </div>
            <div>
                <label for="work-time-filter">Work Time:</label>
                <select class="select-multi" name="work-time-filter" id="work-time-filter">
                    <option value="0" <?php if ($workTimeFilter == '0') echo 'selected'; ?>>All Times</option>
                    <option value="15" <?php if ($workTimeFilter == '15') echo 'selected'; ?>>Up to 15 minutes</option>
                    <option value="30" <?php if ($workTimeFilter == '30') echo 'selected'; ?>>Up to 30 minutes</option>
                    <option value="60" <?php if ($workTimeFilter == '60') echo 'selected'; ?>>Up to 60 minutes</option>
                    <option value="120" <?php if ($workTimeFilter == '120') echo 'selected'; ?>>Up to 120 minutes
                    </option>
                </select>
            </div>
            <div>
                <label for="diet-style-filter">Diet Style:</label>
                <select class="select-multi" name="diet-style-filter" id="diet-style-filter">
                    <option value="all" <?php if ($dietStyleFilter == 'all') echo 'selected'; ?>>All</option>
                    <option value="vegan" <?php if ($dietStyleFilter == 'vegan') echo 'selected'; ?>>Vegan</option>
                    <option value="vegetarian" <?php if ($dietStyleFilter == 'vegetarian') echo 'selected'; ?>>
                        Vegetarian
                    </option>
                    <option value="gluten-free" <?php if ($dietStyleFilter == 'gluten-free') echo 'selected'; ?>>
                        Gluten-Free
                    </option>
                    <option value="paleo" <?php if ($dietStyleFilter == 'paleo') echo 'selected'; ?>>Paleo</option>
                </select>
            </div>
            <div>
                <label for="rating-filter">Star Rating:</label>
                <select class="select-multi" name="rating-filter" id="rating-filter">
                    <option value="0" <?php if ($ratingFilter == '0') echo 'selected'; ?>>All Ratings</option>
                    <option value="5" <?php if ($ratingFilter == '5') echo 'selected'; ?>>5 Stars</option>
                    <option value="4" <?php if ($ratingFilter == '4') echo 'selected'; ?>>4 Stars and up</option>
                    <option value="3" <?php if ($ratingFilter == '3') echo 'selected'; ?>>3 Stars and up</option>
                </select>
            </div>
            <div>
                <button class="select-button" type="submit">Filter</button>
            </div>
        </form>
    </div>
    <br>
    <div class="RecipePreviewLayout">
        <?php if (empty($recipes)): ?>
            <h2>No recipes found</h2>
        <?php else:
            foreach ($recipes as $recipe): ?>
                <div class="RecipePreview">
                    <div class="RecipePictureContainer">
                        <a href="viewRecipe.php?recipeID=<?php echo urlencode($recipe->getRecipeID()); ?>">
                            <img class="RecipePicture" src="<?php echo htmlspecialchars($recipe->getPicturePath()); ?>"
                                 alt="Picture of <?php echo htmlspecialchars($recipe->getName()); ?>">
                        </a>
                    </div>
                    <h2>
                        <a href="viewRecipe.php?recipeID=<?php echo urlencode($recipe->getRecipeID()); ?>"><?php echo htmlspecialchars($recipe->getName()); ?></a>
                    </h2>
                    <span><a href="profil.php?userID=<?= urlencode($recipe->getUserID()); ?>"><?= htmlspecialchars($userList->getUserByID($recipe->getUserID())->getUsername()) ?> </a></span>
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
            <?php endforeach;
            if (!$full) :?>
                <div class="button" id="loadButton">
                    <a href="javascript:void(0);">I want more Recipes!</a>
                </div>
                <noscript>
                    <div class="button"><a href="?full=true">Show all Recipes</a></div>
                </noscript>
            <?php endif;
        endif;
        ?>
    </div>
    <br>
</div>
<script src="./moreRecipes.js"></script>
<?php require './php/include/foot.php'; ?>

</body>
</html>