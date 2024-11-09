<?php

class Recipe
{
    private string $recipeID;
    private string $userID;
    private string $name;
    private string $ingredients;
    private string $instructions;
    private string $mealType;
    private string $workTime;
    private string $dietType;
    private string $creationDate;

    private string $averageRating; // Store the average rating of the recipe
    private string $ratings; // Store the number of ratings of the recipe
    private string $picturePath; // Store the path to the uploaded picture


    public function __construct($recipeID, $userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath)
    {
        $this->recipeID = $recipeID;
        $this->userID = $userID;
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->mealType = $mealType;
        $this->workTime = $workTime;
        $this->dietType = $dietType;
        $this->picturePath = $picturePath;
        $this->creationDate = date("d-m-Y");
        $this->averageRating = 6;
        $this->ratings = 0;
    }


    /* getter and setter for all properties */

    public function getRecipeID(): int
    {
        return $this->recipeID;
    }

    public function setRecipeID($recipeID): void
    {
        $this->recipeID = $recipeID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function setInstructions($instructions): void
    {
        $this->instructions = $instructions;
    }

    public function getMealType(): string
    {
        return $this->mealType;
    }

    public function setMealType($mealType): void
    {
        $this->mealType = $mealType;
    }

    public function getWorkTime(): int
    {
        return $this->workTime;
    }

    public function setWorkTime($workTime): void
    {
        $this->workTime = $workTime;
    }

    public function getDietType(): string
    {
        return $this->dietType;
    }

    public function setDietType($dietType): void
    {
        $this->dietType = $dietType;
    }

    public function getPicturePath(): string
    {
        return $this->picturePath;
    }

    public function setPicturePath($picturePath): void
    {
        $this->picturePath = $picturePath;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate(string $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    public function getAverageRating(): string
    {
        return $this->averageRating;
    }

    public function setAverageRating(string $averageRating): void
    {
        $this->averageRating = $averageRating;
    }

    public function getRatings(): int
    {
        return $this->ratings;
    }

    public function setRatings(int $ratings): void
    {
        $this->ratings = $ratings;
    }

    public function update($userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath)
    {
        $this->userID = $userID;
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->mealType = $mealType;
        $this->workTime = $workTime;
        $this->dietType = $dietType;
        $this->picturePath = $picturePath;
    }

}

?>