<?php
if (!isset($abs_path)) {
    require "path.php";
}

require_once $abs_path . "/php/model/recipeModel/Recipe.php";
require_once $abs_path . "/php/model/recipeModel/RecipeList.php";
require_once $abs_path . "/php/model/reviewModel/Rating.php";
require_once $abs_path . "/php/model/reviewModel/RatingList.php";
require_once $abs_path . "/php/model/commentModel/Comment.php";
require_once $abs_path . "/php/model/commentModel/CommentList.php";
require_once $abs_path . "/php/model/userModel/UserList.php";
require_once $abs_path . "/php/model/userModel/User.php";
require_once $abs_path . "/php/model/favoriteModel/FavoriteList.php";
require_once $abs_path . "/php/model/favoriteModel/Favorite.php";


class RecipeController
{

    public function showRecipe()
    {
        $this->checkId();
        try {
            $recipeList = RecipeList::getInstance();
            return $recipeList->getRecipe($_GET["recipeID"]);
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    private function checkId()
    {
        if (!isset($_REQUEST["recipeID"]) || !is_numeric($_REQUEST["recipeID"])) {
            $this->handleMissingEntryException();
        }
    }

    private function handleMissingEntryException()
    {
        $_SESSION["message"] = "invalid_entry_id";
        header("Location: index.php");
        exit;
    }

    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: index.php");
        exit;
    }

    public function showAuthor($id)
    {
        try {
            $userList = UserList::getInstance();
            return $userList->getUserByID($id)->getUsername();
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function showComments($id)
    {
        try {
            $commentList = CommentList::getInstance();
            return $commentList->getAllCommentsByRecipe($id);
        } catch (InternalCommentDatabaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function showRecipeById($id)
    {
        try {
            $recipeList = RecipeList::getInstance();
            $recipe = $recipeList->getRecipe($id);
            return $recipe;
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingRecipeException $exc) {
            $_SESSION["message"] = "invalid_entry_id";
        }
    }

    public function showRecipesbyUserID($userID)
    {
        try {
            $recipeList = RecipeList::getInstance();
            return $recipeList->getRecipesByUser($userID);
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function addRating($recipeID, $userID, $rating)
    {
        try {
            $ratingList = RatingList::getInstance();
            if ($ratingList->userHasRatedRecipe($userID, $recipeID)) {
                $_SESSION["message"] = "rating_updated";
                $ratingList->updateRating($recipeID, $userID, $rating);
            } else {
                $_SESSION["message"] = "rating_created";
                $ratingList->addRating($recipeID, $userID, $rating);
            }
        } catch (InternalRatingDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function userHasRatedRecipe($recipeID, $userID)
    {
        try {
            $ratingList = RatingList::getInstance();
            return $ratingList->userHasRatedRecipe($recipeID, $userID);
        } catch (InternalRatingDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function getRecipesByPage($page, $recipesPerPage = 3)
    {
        $offset = ($page - 1) * $recipesPerPage;
        try {
            $recipeList = RecipeList::getInstance();
            return $recipeList->getRecipesOffset($offset, $recipesPerPage);
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function addComment()
    {
        $text = $_POST["text"];
        $RecipeID = htmlspecialchars($_POST["recipeID"]);
        if (!$_SESSION['isLoggedIn']) {
            $_SESSION['message'] = "You are not logged in.";
            $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
            header("Location: logIn.php");
            exit();
        } else {
            $Userid = $_SESSION['id'];
        }
        try {
            $commentList = CommentList::getInstance();
            $commentList->newComment($text, $Userid, $RecipeID);
        } catch (InternalCommentDatabaseError $exc) {
            $this->handleInternalErrorException();
        }
        $_SESSION["message"] = "comment_added";
        header("Location: viewRecipe.php?recipeID=$RecipeID");
        exit();

    }

    public function deleteRecipe($id)
    {
        try {
            $this->checkOwner($id, $_SESSION['userID']);
            $commentList = CommentList::getInstance();
            $comments = $commentList->getAllCommentsByRecipe($id);
            foreach ($comments as $comment) {
                $commentList->deleteComment($comment->getCommentID());
            }

            $ratingList = RatingList::getInstance();
            $ratings = $ratingList->getRatingsByRecipe($id);
            foreach ($ratings as $rating) {
                $ratingList->deleteRatingByID($rating->getRatingID());
            }
            $favoriteList = FavoriteList::getInstance();
            $favorites = $favoriteList->getAllFavoritesByRecipeID($id);

            foreach ($favorites as $favorite) {
                $favoriteList->deleteFavorite($favorite->getFavoriteID());
            }

            $recipeList = RecipeList::getInstance();
            $recipeList->deleteRecipe($id);
            $_SESSION["message"] = "recipe_deleted";
            header("Location: ./index.php");
            exit();
        } catch (InternalErrorException|InternalRatingDataBaseError|InternalFavoriteDatabaseError|InternalCommentDatabaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingRecipeException $exc) {
            $_SESSION["message"] = "recipe_not_found_delete";
            header("Location: ./index.php");
            exit();
        }
    }

    private function checkOwner($recipeID, $userID)
    {
        try {
            $recipeList = RecipeList::getInstance();
            $recipe = $recipeList->getRecipe($recipeID);
            if ($recipe->getUserID() != $userID) {
                $_SESSION["message"] = "not_owner";
                header("Location: ./viewRecipe.php?recipeID=$recipeID");
                exit();
            }
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function deleteComment($id)
    {
        try {
            $this->checkCommentOwner($id, $_SESSION['userID']);
            $commentList = CommentList::getInstance();
            $recipeID = $commentList->getCommentByID($id)->getRecipeID();
            $commentList->deleteComment($id);
            $_SESSION["message"] = "comment_deleted";
            header("Location: ./viewRecipe.php?recipeID=" . $recipeID);
            exit();
        } catch (InternalCommentDatabaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingCommentException $exc) {
            $_SESSION["message"] = "comment_not_found";
            header("Location: ./index.php");
            exit();
        }
    }

    private function checkCommentOwner($id, $userID)
    {
        try {
            $commentList = CommentList::getInstance();
            $comment = $commentList->getCommentByID($id);
            if ($comment->getUserID() != $userID) {
                $_SESSION["message"] = "not_owner";
                header("Location: ./viewRecipe.php?recipeID=" . $comment->getRecipeID());
                exit();
            }
        } catch (InternalCommentDatabaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingCommentException $e) {
            $_SESSION["message"] = "comment_not_found";
            header("Location: ./index.php");
            exit();
        }
    }

    public function createRecipe()
    {
        $title = $_POST["nameRecipe"];
        $instructions = $_POST["instructions"];
        $ingredients = $_POST["ingredients"];
        $workTime = $_POST["worktime"];
        $mealType = $_POST["meal"];
        $dietType = $_POST["diet"];
        $userID = $_SESSION["userID"];
        $_SESSION['Form_CreateRecipe']["nameRecipe"] = $title;
        $_SESSION['Form_CreateRecipe']["instructions"] = $instructions;
        $_SESSION['Form_CreateRecipe']["ingredients"] = $ingredients;
        $_SESSION['Form_CreateRecipe']["worktime"] = $workTime;
        $_SESSION['Form_CreateRecipe']["meal"] = $mealType;
        $_SESSION['Form_CreateRecipe']["diet"] = $dietType;

        // $this->checkTitle($title);  works but not really needed

        try {
            $recipeList = RecipeList::getInstance();


            $target_dir = "./php/model/recipeModel/uploadedRecipePictures/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                $_SESSION["message"] = "file_exists";
                $uploadOk = 0;
                header("Location: ./createRecipe.php");
                exit();
            }

            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                $_SESSION["message"] = "file_too_large";
                $uploadOk = 0;
                header("Location: ./createRecipe.php");
                exit();
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $_SESSION["message"] = "file_type_not_allowed";
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                $_SESSION["message"] = "image_upload_failed";
                header("Location: ./createRecipe.php");
                exit();
            } else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $recipeList->newRecipe($userID, $title, $ingredients, $instructions, $mealType, $workTime, $dietType, $target_file);
            } else {
                $_SESSION["message"] = "image_upload_failed";
                header("Location: ./createRecipe.php");
                exit();
            }
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
        $_SESSION["message"] = "recipe_created";
        unset ($_SESSION['Form_CreateRecipe']['nameRecipe']);
        unset ($_SESSION['Form_CreateRecipe']['instructions']);
        unset ($_SESSION['Form_CreateRecipe']['ingredients']);
        unset ($_SESSION['Form_CreateRecipe']['worktime']);
        unset ($_SESSION['Form_CreateRecipe']['meal']);
        unset ($_SESSION['Form_CreateRecipe']['diet']);

        header("Location: ./index.php");
        exit();

    }

    public function updateRecipe($recipeID, $nameRecipe, $description, $ingredients, $worktime, $meal, $diet)
    {
        $this->checkId();
        // $this->checkTitleUpdate($nameRecipe);  works but not really needed
        try {
            $this->checkOwner($recipeID, $_SESSION['userID']);
            $recipeList = RecipeList::getInstance();
            $recipeList->updateRecipe($recipeID, $_SESSION['userID'], $nameRecipe, $ingredients, $description, $meal, $worktime, $diet);
            $_SESSION["message"] = "recipe_updated";
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function showRecipesbyUser($userID)
    {
        try {
            $recipeList = RecipeList::getInstance();
            return $recipeList->getRecipesByUser($userID);
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function showRating($recipeID, $userID)
    {
        try {
            $ratingList = RatingList::getInstance();
            return $ratingList->getRating($recipeID, $userID);
        } catch (InternalRatingDataBaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingRatingException $e) {
            return null;
        }
    }

    public function getRecipeByID($recipeID)
    {
        try {
            $recipeList = RecipeList::getInstance();
            return $recipeList->getRecipe($recipeID);
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        } catch (MissingRecipeException $exc) {
            $this->handleMissingEntryException();
        }
    }

    private function checkTitle($title)
    {
        try {
            $recipeList = RecipeList::getInstance();
            $recipes = $recipeList->getRecipes();
            foreach ($recipes as $recipe) {
                if ($recipe->getName() == $title) {
                    $_SESSION["message"] = "title_in_use";
                    header("Location: ./createRecipe.php");
                    exit();
                }
            }
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }

    }

    private function checkTitleUpdate($nameRecipe)
    {
        try {
            $recipeList = RecipeList::getInstance();
            $recipes = $recipeList->getRecipes();
            foreach ($recipes as $recipe) {
                if ($recipe->getName() == $nameRecipe && $recipe->getRecipeID() != htmlspecialchars($_POST["recipeID"])) {
                    $_SESSION["message"] = "title_in_use";
                    header("Location: ./editRecipe.php?recipeID=" . htmlspecialchars($_POST["recipeID"]));
                    exit();
                }
            }
        } catch (InternalRecipeDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }


}