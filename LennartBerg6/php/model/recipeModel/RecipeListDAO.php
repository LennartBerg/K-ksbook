<?php

interface RecipeListDAO
{
    public function newRecipe($userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath);

    public function getRecipe($recipeID);

    public function deleteRecipe($recipeID);

    public function updateRecipe($recipeID, $userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType);

    public function getRecipes();

    public function getRecipesByMealType($mealType);

    public function getRecipesByMaxTime($maxTime);

    public function getRecipesByDietType($dietType);

    public function getRecipesByUser($user);

}

class MissingRecipeException extends Exception
{
}


?>
