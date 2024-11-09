<?php
if (!isset($abs_path)) {
    require_once "./path.php";
}


require_once $abs_path . "/php/model/recipeModel/RecipeListDAO.php";
require_once $abs_path . "/php/model/recipeModel/Recipe.php";

class RecipeListSession implements RecipeListDAO
{
    private static $instance = null;
    private $recipes = array();

    private function __construct()
    {
        if (isset($_SESSION["recipes"])) {
            $this->recipes = unserialize($_SESSION["recipes"]);
        } else {
            if (!isset($abs_path)) {
                require "./path.php";
            }
            $this->recipes[1] = new Recipe(0, 0, "Fried Tofu", "Tofu, Soy Sauce, Salt, Pepper, Oil", "1. Cut Tofu. 2. Fry Tofu. 3. Add Soy Sauce, Salt, Pepper.", "lunch", 20, "vegetarian", ($abs_path . "php/model/recipeModel/uploadedRecipePictures/friedTofu.png"));
            $this->recipes[2] = new Recipe(1, 0, "Fried Tofu with Rice", "Tofu, Soy Sauce, Salt, Pepper, Oil, Rice", "1. Cut Tofu. 2. Fry Tofu. 3. Add Soy Sauce, Salt, Pepper. 4. Cook Rice.", "lunch", 30, "vegetarian", $abs_path . "php/model/recipeModel/uploadedRecipePictures/friedTofuRice.png");
            $this->recipes[3] = new Recipe(2, 0, "Cake Sponge", "Flour, Sugar, Eggs, Baking Powder, Vanilla Extract", "1. Mix Flour, Sugar, Eggs, Baking Powder, Vanilla Extract. 2. Bake.", "snack", 40, "non-vegetarian", $abs_path . "php/model/recipeModel/uploadedRecipePictures/base.png");
            $_SESSION["recipes"] = serialize($this->recipes);
            $_SESSION["nextId"] = 4;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new RecipeListSession();
        }

        return self::$instance;
    }

    public function newRecipe($userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath)
    {
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $this->recipes[$_SESSION["nextId"]] = new Recipe($_SESSION["nextId"], $userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath);
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $_SESSION["recipes"] = serialize($this->recipes);
    }

    public function getRecipe($recipeID)
    {
        foreach ($this->recipes as $recipe) {
            if ($recipe->getRecipeID() == $recipeID) {
                return $recipe;
            }
        }
        throw new MissingRecipeException();
    }

    public function deleteRecipe($recipeID)
    {
        foreach ($this->recipes as $key => $recipe) {
            if ($recipe->getRecipeID() == $recipeID) {
                unset($this->recipes[$key]);
                $_SESSION["recipes"] = serialize($this->recipes);
                return;
            }
        }
        throw new MissingRecipeException();
    }

    public function updateRecipe($recipeID, $userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType)
    {
        foreach ($this->recipes as $recipe) {
            if ($recipe->getRecipeID() == $recipeID) {
                $recipe->update($userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath);
                $_SESSION["recipes"] = serialize($this->recipes);
                return $recipe;
            }
        }
        throw new MissingRecipeException();
    }

    public function getRecipes()
    {
        return $this->recipes;
    }

    public function getRecipesByMealType($mealType)
    {
        $filteredRecipes = array();
        foreach ($this->recipes as $recipe) {
            if ($recipe->getMealType() == $mealType) {
                $filteredRecipes[] = $recipe;
            }
        }
        return $filteredRecipes;
    }

    public function getRecipesByMaxTime($maxTime)
    {
        $filteredRecipes = array();
        foreach ($this->recipes as $recipe) {
            if ($recipe->getWorkTime() <= $maxTime) {
                $filteredRecipes[] = $recipe;
            }
        }
        return $filteredRecipes;
    }

    public function getRecipesByDietType($dietType)
    {
        $filteredRecipes = array();
        foreach ($this->recipes as $recipe) {
            if ($recipe->getDietType() == $dietType) {
                $filteredRecipes[] = $recipe;
            }
        }
        return $filteredRecipes;
    }

    public function getRecipesByUser($user)
    {
        $filteredRecipes = array();
        foreach ($this->recipes as $recipe) {
            if ($recipe->getUserID() == $user) {
                $filteredRecipes[] = $recipe;
            }
        }
        return $filteredRecipes;
    }
}


?>