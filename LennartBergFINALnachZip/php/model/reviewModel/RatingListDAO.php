<?php

interface RatingListDAO
{
    public function getRatingsByRecipe($recipeID);

    public function getRatingByID($ratingID);

    public function deleteRatingByID($ratingID);

    public function addRating($recipeID, $userID, $rating);

    public function updateRatingByRatingID($ratingID, $rating);

    public function getAverageRatingByRecipe($recipeID);

    public function userHasRatedRecipe($userID, $recipeID);

    public function updateRating($recipeID, $userID, $rating);
}

class MissingRatingException extends Exception
{
}

?>
