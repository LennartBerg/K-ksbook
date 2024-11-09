<?php

interface FavoriteListDAO
{
    public function newFavorite($userID, $recipeID);

    public function deleteFavorite($favoritesID);

    public function getFavoriteByID($favoritesID);

    public function getAllFavoritesByUserID($userID);

    public function deleteAllFavoritesByUserID($userID);

    public function getAllFavoritesByRecipeID($recipeID);

    public function deleteAllFavoritesByRecipeID($recipeID);

}

class MissingFavoriteException extends Exception
{
}

?>