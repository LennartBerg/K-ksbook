<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}
$pageTitle = "Edit your Recipe";
?>
<!DOCTYPE html>
<html lang="en">
<?php require './php/include/head.php'; ?>
<link rel="stylesheet" type="text/css" href="./assets/css/create.css">
</head>
<body>
<?php require './php/include/nav.php'; ?>
<main>
    <section>
        <h1>Edit your Recipe</h1>
        <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "update_recipe"): ?>
            <p class="GreenNotification">
                The recipe was updated!
            </p>
        <?php endif;
        unset($_SESSION["message"]);
        ?>
        <div>
            <form class="createForm" action="./editRecipeAction.php" method="post">
                <div class="mainProperties optionalProperties">
                    <h2>Main Properties</h2>
                    <label for="name"> Title<br>
                        <input id="name" type="text" maxlength="20" name="nameRecipe" placeholder="Title" required
                               value="<?= htmlspecialchars($recipe->getName()); ?>"></label>
                    <br>
                    <label for="ingredients">Ingredients with Quantities</label> <br>
                    <textarea id="ingredients" name="ingredients" rows="15" maxlength="10000"
                              placeholder="Enter ingredients with quantities (e.g., 500g flour, 2 eggs)"
                              required><?= htmlspecialchars($recipe->getIngredients()); ?></textarea>
                    <br>
                    <label for="instructions">Instructions</label> <br>
                    <textarea id="instructions" name="instructions" rows="15" maxlength="10000"
                              placeholder="Enter recipe description"
                              required><?= htmlspecialchars($recipe->getInstructions()); ?></textarea>
                    <br>
                </div>
                <div class="optionalProperties">
                    <h3>Further Properties</h3>
                    <br>
                    <label for="meal">Meal Type</label> <br>
                    <select required class="select-multi" id="meal" name="meal">
                        <option value="">-- Select meal type --</option>
                        <option value="breakfast" <?php if ($recipe->getMealType() == "breakfast") echo("selected") ?>>
                            Breakfast
                        </option>
                        <option value="lunch" <?php if ($recipe->getMealType() == "lunch") echo("selected") ?>>Lunch
                        </option>
                        <option value="dinner" <?php if ($recipe->getMealType() == "dinner") echo("selected") ?>>Dinner
                        </option>
                        <option value="snack" <?php if ($recipe->getMealType() == "snack") echo("selected") ?>>Snack
                        </option>
                        <option value="drink" <?php if ($recipe->getMealType() == "drink") echo("selected") ?>>Drink
                        </option>
                    </select>
                    <br>
                    <label for="worktime">Work Time (in minutes)</label> <br>
                    <input required type="number" id="worktime" name="worktime" min="1" max="3000"
                           placeholder="Work time in min." value="<?= htmlspecialchars($recipe->getWorkTime()); ?>">
                    <br>
                    <label for="diet">Diet Type</label> <br>
                    <select required class="select-multi" id="diet" name="diet">
                        <option value="">-- Select diet type --</option>
                        <option value="none" <?php if ($recipe->getDietType() == "none") echo("selected") ?>>None
                        </option>
                        <option value="vegetarian" <?php if ($recipe->getDietType() == "vegetarian") echo("selected") ?>>
                            Vegetarian
                        </option>
                        <option value="vegan" <?php if ($recipe->getDietType() == "vegan") echo("selected") ?>>Vegan
                        </option>
                        <option value="gluten-free" <?php if ($recipe->getDietType() == "gluten-free") echo("selected") ?>>
                            Gluten-free
                        </option>
                        <option value="paleo" <?php if ($recipe->getDietType() == "paleo") echo("selected") ?>>Paleo
                        </option>
                    </select>
                    <br>
                </div>
                <input type="hidden" name="recipeID" value="<?= htmlspecialchars($recipe->getRecipeID()) ?>">
                <button class="button" type="submit">Edit Recipe</button>
            </form>
        </div>
    </section>
</main>
<?php
require './php/include/foot.php';
?>
</body>
</html>


