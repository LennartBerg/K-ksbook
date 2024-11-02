<?php
if (!isset($abs_path)) {
    require_once "../../../path.php";
}

require_once $abs_path . "/php/model/reviewModel/RatingListDAO.php";
require_once $abs_path . "/php/model/reviewModel/Rating.php";
require_once $abs_path . "/php/model/recipeModel/Recipe.php";
require_once $abs_path . "/php/model/recipeModel/RecipeListSession.php";


class RatingListSession implements RatingListDAO
{
    private static $instance = null;
    private $ratings = array();

    private function __construct()
    {
        if (isset($_SESSION["ratings"])) {
            $this->ratings = unserialize($_SESSION["ratings"]);
        } else {
            // $ratingID, $recipeID, $userID, $rating
            $this->ratings[1] = new Rating(0, 0, 0, 5);
            $this->ratings[2] = new Rating(1, 0, 1, 4);
            $this->ratings[3] = new Rating(2, 0, 2, 3);
            $this->ratings[4] = new Rating(3, 1, 0, 2);
            $this->ratings[5] = new Rating(4, 1, 1, 1);
            $this->ratings[6] = new Rating(5, 1, 2, 5);
            // refresh recipe average rating and number of ratings
            $this->updateRecipe(0);
            $this->updateRecipe(1);
            $_SESSION["ratings"] = serialize($this->ratings);
            $_SESSION["nextId"] = 6;
        }
    }

    public function updateRecipe($RecipeID)
    {
        $recipeList = RecipeListSession::getInstance();
        $recipe = $recipeList->getRecipe($RecipeID);
        $averageRating = $this->getAverageRatingByRecipe($RecipeID);
        $recipe->setAverageRating($averageRating);
        $ratings = $this->getRatingsByRecipe($RecipeID);
        $recipe->setRatings(count($ratings));
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new RatingListSession();
        }

        return self::$instance;
    }

    public function getAverageRatingByRecipe($recipeID)
    {
        $ratingsByRecipe = $this->getRatingsByRecipe($recipeID);
        $averageRating = 0;
        foreach ($ratingsByRecipe as $rating) {
            $averageRating += $rating->getRating();
        }
        if (count($ratingsByRecipe) == 0) {
            return 0;
        }
        return round($averageRating = $averageRating / count($ratingsByRecipe), 2);
    }

    public function getRatingsByRecipe($recipeID)
    {
        $ratingsByRecipe = array();
        foreach ($this->ratings as $rating) {
            if ($rating->getRecipeID() == $recipeID) {
                $ratingsByRecipe[] = $rating;
            }
        }
        return $ratingsByRecipe;
    }

    public function getRatingByID($ratingID)
    {
        foreach ($this->ratings as $rating) {
            if ($rating->getRatingID() == $ratingID) {
                return $rating;
            }
        }
        throw new MissingRatingException();
    }

    public function deleteRatingByID($ratingID)
    {
        foreach ($this->ratings as $key => $rating) {
            if ($rating->getRatingID() == $ratingID) {
                unset($this->ratings[$key]);
                $_SESSION["ratings"] = serialize($this->ratings);
                $this->updateRecipe($rating->getRecipeID());
                return;
            }
        }
        throw new MissingRatingException();
    }

    public function addRating($recipeID, $userID, $rating)
    {
        $this->ratings[$_SESSION["nextId"]] = new Rating($_SESSION["nextId"], $recipeID, $userID, $rating);
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $_SESSION["ratings"] = serialize($this->ratings);
        $this->updateRecipe($recipeID);
    }

    public function updateRatingByRatingID($ratingID, $rating)
    {
        foreach ($this->ratings as $rating) {
            if ($rating->getRatingID() == $ratingID) {
                $rating->setRating($rating);
                $_SESSION["ratings"] = serialize($this->ratings);
                return $rating;
            }
        }
        throw new MissingRatingException();
    }

    public function updateRating($recipeID, $userID, $rating)
    {
        foreach ($this->ratings as $rating) {
            if ($rating->getUserID() == $userID && $rating->getRecipeID() == $recipeID) {
                $rating->setRating($rating);
                $_SESSION["ratings"] = serialize($this->ratings);
                $this->updateRecipe($recipeID);
                return $rating;
            }
        }
        throw new MissingRatingException();
    }

    public function userHasRatedRecipe($userID, $recipeID)
    {
        foreach ($this->ratings as $rating) {
            if ($rating->getUserID() == $userID && $rating->getRecipeID() == $recipeID) {
                return true;
            }
        }
        return false;
    }

}

?>
