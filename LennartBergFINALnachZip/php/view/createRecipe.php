<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}
$pageTitle = "Create Recipe";
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
        <h1>Create a Recipe</h1>
        <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "title_in_use"): ?>
            <p class="RedNotification">
                The title is already in use.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "image_upload_failed"): ?>
            <p class="RedNotification">
                Image upload failed.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "file_exists"): ?>
            <p class="RedNotification">
                File already exists.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "file_too_large"): ?>
            <p class="RedNotification">
                File too large.
            </p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "file_type_not_allowed"): ?>
            <p class="RedNotification">
                File type not allowed. Only JPG, JPEG, PNG & GIF files are allowed.";
            </p>
        <?php endif;
        unset($_SESSION["message"]);
        ?>
        <div>
            <form enctype="multipart/form-data" class="createForm" action="createRecipeAction.php" method="post">
                <div class="mainProperties optionalProperties">
                    <h2>Main Properties</h2>
                    <label for="name"> Title<br>
                        <input id="name" type="text" maxlength="20" name="nameRecipe" placeholder="Title" required
                               value="<?= htmlspecialchars($_SESSION['Form_CreateRecipe']["nameRecipe"] ?? ''); ?>"></label>
                    <br>
                    <label for="ingredients">Ingredients with Quantities</label> <br>
                    <textarea id="ingredients" name="ingredients" rows="15" maxlength="10000"
                              placeholder="Enter ingredients with quantities (e.g., 500g flour, 2 eggs)"
                              required><?= htmlspecialchars($_SESSION['Form_CreateRecipe']["ingredients"] ?? ''); ?></textarea>
                    <br>
                    <label for="instructions">Instructions</label> <br>
                    <textarea id="instructions" name="instructions" rows="15" maxlength="10000"
                              placeholder="Enter recipe description"
                              required><?= htmlspecialchars($_SESSION['Form_CreateRecipe']["instructions"] ?? ''); ?></textarea>
                    <br>
                    <label for="fileToUpload" id="fileToUpload">Picture</label> <br>
                    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" onchange="loadFile(event)"
                           required>
                    <img class="imagePreview hidden" id="imagePreview" src="#" alt="Image Preview">
                </div>
                <div class="optionalProperties">
                    <h3>Further Properties</h3>
                    <br>
                    <label for="meal">Meal Type</label> <br>
                    <select required class="select-multi" id="meal" name="meal">
                        <option value="">-- Select meal type --</option>
                        <option value="breakfast" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['meal']) == "breakfast") echo("selected"); ?>>
                            Breakfast
                        </option>
                        <option value="lunch" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['meal']) == "lunch") echo("selected"); ?>>
                            Lunch
                        </option>
                        <option value="dinner" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['meal']) == "dinner") echo("selected"); ?>>
                            Dinner
                        </option>
                        <option value="snack" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['meal']) == "snack") echo("selected"); ?>>
                            Snack
                        </option>
                        <option value="drink" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['meal']) == "drink") echo("selected"); ?>>
                            Drink
                        </option>
                    </select>
                    <br>
                    <label for="worktime">Work Time (in minutes)</label> <br>
                    <input required type="number" id="worktime" name="worktime" min="1" max="3000"
                           placeholder="Work time in min."
                           value="<?php if (isset($_SESSION['Form_CreateRecipe']['worktime'])) echo(htmlspecialchars($_SESSION['Form_CreateRecipe']['worktime'])); ?>">
                    <br>
                    <label for="diet">Diet Type</label> <br>
                    <select required class="select-multi" id="diet" name="diet">
                        <option value="">-- Select diet type --</option>
                        <option value="none" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['diet']) == "none") echo("selected"); ?>>
                            None
                        </option>
                        <option value="vegetarian" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['diet']) == "vegetarian") echo("selected"); ?>>
                            Vegetarian
                        </option>
                        <option value="vegan" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['diet']) == "vegan") echo("selected"); ?>>
                            Vegan
                        </option>
                        <option value="gluten-free" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['diet']) == "gluten-free") echo("selected"); ?>>
                            Gluten-free
                        </option>
                        <option value="paleo" <?php if (htmlspecialchars($_SESSION['Form_CreateRecipe']['diet']) == "paleo") echo("selected"); ?>>
                            Paleo
                        </option>
                    </select>
                </div>
                <label>
                    <input type="checkbox" required>I hereby accept that my information and picture will be used and
                    published on Köksbook.
                </label> <br>
                <br>
                <button class="select-button" type="submit">Save Recipe</button>
                <br>
            </form>
        </div>
    </section>
</main>
<?php
require './php/include/foot.php';
?>
<!-- https://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded -->
<script src="./imagePreview.js"></script>
</body>
</html>
