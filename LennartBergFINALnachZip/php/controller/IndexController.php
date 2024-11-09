<?php
if (!isset($abs_path)) {
    require_once "./../../path.php";
}

require_once $abs_path . "/php/model/recipeModel/Recipe.php";
require_once $abs_path . "/php/model/recipeModel/RecipeList.php";
require_once $abs_path . "/php/model/reviewModel/Rating.php";
require_once $abs_path . "/php/model/reviewModel/RatingList.php";
require_once $abs_path . "/php/model/userModel/UserList.php";
require_once $abs_path . "/php/model/userModel/User.php";


$userList = UserList::getInstance();


class IndexController
{
    public function request()
    {
        try {

            if (!isset($abs_path)) {
                require_once "./path.php";
            }


            $recipeList = RecipeList::getInstance();
            $recipes = $recipeList->getRecipes();
            // filter Recipes depending on the filter options
            if (isset($_SESSION['filter']['meal-type-filter']) && $_SESSION['filter']['meal-type-filter'] != "all") {
                $recipes = array_filter($recipes, function ($recipe) {
                    return $recipe->getMealType() == $_SESSION['filter']['meal-type-filter'];
                });
            }

            if (isset($_SESSION['filter']['work-time-filter']) && $_SESSION['filter']['work-time-filter'] != "0") {
                $recipes = array_filter($recipes, function ($recipe) {
                    return $recipe->getWorkTime() <= $_SESSION['filter']['work-time-filter'];
                });
            }

            if (isset($_SESSION['filter']['diet-style-filter']) && $_SESSION['filter']['diet-style-filter'] != "all") {
                $recipes = array_filter($recipes, function ($recipe) {
                    return $recipe->getDietType() == $_SESSION['filter']['diet-style-filter'];
                });
            }

            if (isset($_SESSION['filter']['rating-filter']) && $_SESSION['filter']['rating-filter'] != "0") {
                $recipes = array_filter($recipes, function ($recipe) {
                    return $recipe->getAverageRating() >= $_SESSION['filter']['rating-filter'];
                });
            }
            return $recipes;
        } catch (InternalErrorException|InternalFavoriteDatabaseError|InternalCommentDatabaseError|InternalUserDataBaseError|InternalRatingDataBaseError|InternalRecipeDataBaseError $exc) {
            $_SESSION["message"] = "internal_error";
        }

    }
}

?>