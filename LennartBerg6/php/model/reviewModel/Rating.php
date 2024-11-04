<?php

class Rating
{
    private int $ratingID;
    private int $recipeID;
    private int $userID;
    private int $rating;

    public function __construct($ratingID, $recipeID, $userID, $rating)
    {
        $this->ratingID = $ratingID;
        $this->recipeID = $recipeID;
        $this->userID = $userID;
        $this->rating = $rating;
    }

    public function getRatingID(): int
    {
        return $this->ratingID;
    }

    public function setRatingID(int $ratingID): void
    {
        $this->ratingID = $ratingID;
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

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }


}

?>