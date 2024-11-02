<?php
if (!isset($abs_path)) {
    require_once "../../../path.php";
}

require_once $abs_path . "/php/model/favoriteModel/FavoriteListDAO.php";
require_once $abs_path . "/php/model/favoriteModel/Favorite.php";


class FavoriteListSession implements FavoriteListDAO
{
    private static $instance = null;
    private $favorites = array();

    public function __construct()
    {
        if (isset($_SESSION["favorites"])) {
            $this->favorites = unserialize($_SESSION["favorites"]);
        } else {
            $this->favorites[0] = new Favorite(0, 0, 0);
            $this->favorites[1] = new Favorite(1, 0, 1);
            $this->favorites[2] = new Favorite(2, 0, 2);
            $this->favorites[3] = new Favorite(3, 1, 0);
            $this->favorites[4] = new Favorite(4, 1, 1);
            $this->favorites[5] = new Favorite(5, 2, 0);
            $_SESSION["favorites"] = serialize($this->favorites);
            $_SESSION["nextId"] = 6;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FavoriteListSession();
        }
        return self::$instance;
    }

    public function newFavorite($userID, $recipeID)
    {
        $this->favorites[$_SESSION["nextId"]] = new Favorite($_SESSION["nextId"], $userID, $recipeID);
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $_SESSION["favorites"] = serialize($this->favorites);
    }

    public function getFavoriteByID($favoriteID)
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getFavoriteID() == $favoriteID) {
                return $favorite;
            }
        }
        throw new MissingFavoriteException();
    }

    public function deleteFavorite($favoriteID)
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getFavoriteID() == $favoriteID) {
                unset($this->favorites[$favoriteID]);
                $_SESSION["favorites"] = serialize($this->favorites);
                return;
            }
        }
        throw new MissingFavoriteException();
    }

    public function getAllFavoritesByUserID($userID)
    {
        $userFavorites = array();
        foreach ($this->favorites as $favorite) {
            if ($favorite->getUserID() == $userID) {
                $userFavorites[] = $favorite->getRecipeID();
            }
        }
        return $userFavorites;
    }

    public function getAllFavoritesByRecipeID($recipeID)
    {
        $recipeFavorites = array();
        foreach ($this->favorites as $favorite) {
            if ($favorite->getRecipeID() == $recipeID) {
                $recipeFavorites[] = $favorite;
            }
        }
        return $recipeFavorites;
    }

    public function deleteAllFavoritesByUserID($userID)
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getUserID() == $userID) {
                unset($this->favorites[$favorite->getFavoriteID()]);
            }
        }
        $_SESSION["favorites"] = serialize($this->favorites);
    }

    public function deleteAllFavoritesByRecipeID($recipeID)
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getRecipeID() == $recipeID) {
                unset($this->favorites[$favorite->getFavoriteID()]);
            }
        }
        $_SESSION["favorites"] = serialize($this->favorites);
    }

    public function getAllFavorites()
    {
        return $this->favorites;
    }
}

?>