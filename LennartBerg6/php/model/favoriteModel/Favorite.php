<?php

class Favorite
{
    private int $favoriteID;
    private int $recipeID;
    private int $userID;

    public function __construct($favoriteID, $recipeID, $userID)
    {
        $this->favoriteID = $favoriteID;
        $this->recipeID = $recipeID;
        $this->userID = $userID;
    }

    public function getRecipeID(): int
    {
        return $this->recipeID;
    }

    public function setRecipeID(int $recipeID): void
    {
        $this->recipeID = $recipeID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    public function getFavoriteID(): int
    {
        return $this->favoriteID;
    }

    public function setFavoriteID(int $favoriteID): void
    {
        $this->favoriteID = $favoriteID;
    }
}

?>