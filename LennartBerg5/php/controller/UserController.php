<?php

if (!isset($abs_path)) {
    require "./path.php";
}

require_once $abs_path . "/php/model/userModel/User.php";
require_once $abs_path . "/php/model/userModel/UserList.php";
require_once $abs_path . "/php/model/favoriteModel/Favorite.php";
require_once $abs_path . "/php/model/favoriteModel/FavoriteList.php";
require_once $abs_path . "/php/model/recipeModel/Recipe.php";
require_once $abs_path . "/php/model/recipeModel/RecipeList.php";
require_once $abs_path . "/php/model/reviewModel/RatingList.php";
require_once $abs_path . "/php/model/reviewModel/Rating.php";
require_once $abs_path . "/php/model/commentModel/CommentList.php";
require_once $abs_path . "/php/model/commentModel/Comment.php";

class UserController
{

    public function logIn()
    {
        $this->checkInput();
        $this->checkUser();
        $this->setSession();
        header("Location: ./index.php");
        exit;
    }

    private function checkInput()
    {
        if (!isset($_POST["email"]) || !isset($_POST["password"])) {
            $this->handleMissingEntryException();
        }
    }

    private function handleMissingEntryException()
    {
        $_SESSION["message"] = "missing_entry";
        $_SESSION['Form_LogIn']["email"] = htmlspecialchars($_POST["email"]);
        header("Location: ./logIn.php");
        exit;
    }

    private function checkUser()
    {
        $userList = UserList::getInstance();

        $user = $userList->getUserByEmail(htmlspecialchars($_POST["email"]));
        if ($user === null || !$user->checkPassword(htmlspecialchars($_POST["password"]))) {

            $this->handleInvalidLoginException();
        }
    }

    private function checkPassword()
    {
        if (htmlspecialchars($_POST["password"]) !== htmlspecialchars($_POST["password_repeat"])) {
            $this->handleInvalidRegisterException();
        }
    }

    private function handleInvalidRegisterException()
    {
        $_SESSION["message"] = "invalid_register_password";
        $_SESSION['Form_Register']["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION['Form_Register']["name"] = htmlspecialchars($_POST["name"]);
        $_SESSION['Form_Register']["description"] = htmlspecialchars($_POST["description"]);
        header("Location: ./register.php");
        exit;
    }

    private function handleInvalidLoginException()
    {
        $_SESSION["message"] = "invalid_login";
        $_SESSION['Form_LogIn']["email"] = htmlspecialchars($_POST["email"]);
        header("Location: ./logIn.php");
        exit;
    }

    private function setSession()
    {
        $userList = UserList::getInstance();
        $user = $userList->getUserByEmail(htmlspecialchars($_POST["email"]));
        $_SESSION["userID"] = $user->getUserID();
        $_SESSION["id"] = $user->getUserID();
        $_SESSION["isLoggedIn"] = true;
        $_SESSION["ownUserID"] = $user->getUserID();
        $_SESSION["message"] = "login";
    }

    public function logOut()
    {
        session_destroy();
        session_unset();
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION["message"] = "logout";
        header("Location: ./index.php");
        exit;
    }

    public function register()
    {
        $this->checkInputRegister();
        $this->checkExistingUser();
        $this->checkPassword();
        $this->createUser();
        $_SESSION["message"] = "new_user";
        unset($_SESSION['Form_Register']);
        header("Location: ./logIn.php");
        exit;
    }

    public function checkInputRegister()
    {
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_repeat"]) || !isset($_POST["name"]) || !isset($_POST["description"])) {
            $this->handleMissingEntryExceptionRegister();
        }
    }

    private function handleMissingEntryExceptionRegister()
    {
        $_SESSION["message"] = "missing_entry_register";
        $_SESSION['Form_Register']["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION['Form_Register']["name"] = htmlspecialchars($_POST["name"]);
        $_SESSION['Form_Register']["description"] = htmlspecialchars($_POST["description"]);
        header("Location: ./register.php");
        exit;
    }

    public function checkExistingUser()
    {
        try {
            $userList = UserList::getInstance();
            $user = $userList->getUserByEmail(htmlspecialchars($_POST["email"]));
            if ($user !== null) {
                $this->handleExistingUserException("email");
            }
            $user = $userList->getUserByName(htmlspecialchars($_POST["name"]));
            if ($user !== null) {
                $this->handleExistingUserException("name");
            }
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    private function handleExistingUserException($string)
    {
        $_SESSION["message"] = "existing_user" . $string;
        $_SESSION['Form_Register']["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION['Form_Register']["name"] = htmlspecialchars($_POST["name"]);
        $_SESSION['Form_Register']["description"] = htmlspecialchars($_POST["description"]);
        header("Location: ./register.php");
        exit;
    }

    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: index.php");
        exit;
    }

    public function createUser()
    {
        try {
            $userList = UserList::getInstance();
            $userList->newUser(htmlspecialchars($_POST["name"]), htmlspecialchars($_POST["password"]), htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["description"]));
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function showUser()
    {
        $this->checkId();
        try {
            $userList = UserList::getInstance();
            return $userList->getUserByID(htmlspecialchars($_GET["userID"]));
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    private function checkId()
    {
        if (!isset($_REQUEST["userID"]) || !is_numeric($_REQUEST["userID"])) {
            $this->handleMissingEntryException();
        }
    }

    public function showUserById($id)
    {
        try {
            $userList = UserList::getInstance();
            return $userList->getUserByID($id);
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function getFavorites($userID)
    {
        try {
            $favoritesList = FavoriteList::getInstance();
            $recipeList = RecipeList::getInstance();
            $return = [];
            foreach ($favoritesList->getAllFavoritesByUserID($userID) as $recipeID) {
                $return[] = $recipeList->getRecipe($recipeID);
            }
            return $return;
        } catch (InternalFavoriteDatabaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function changeDescription($description)
    {
        try {
            $userList = UserList::getInstance();
            if (isset($_SESSION["userID"]) && isset($_POST["userID"]) && $description != "") {
                if ($_SESSION["userID"] == $_POST["userID"]) {
                    $userList->updateUserDescription($_POST["userID"], $description);
                    $_SESSION["message"] = "description_updated";
                    header("Location: ./profil.php?userID=" . $_POST["userID"]);
                    exit();
                } else {
                    $_SESSION["message"] = "not_owner";
                    header("Location: ./profil.php?userID=" . $_POST["userID"]);
                    exit();
                }
            } else {
                $_SESSION["message"] = "no_description";
                header("Location: ./profil.php?userID=" . $_POST["userID"]);
                exit();
            }
        } catch (InternalUserDataBaseError $e) {
            $this->handleInternalErrorException();
        } catch (MissingUserException $e) {
            $_SESSION["message"] = "user_not_found";
            header("Location: ./logIn.php");
            exit();
        }
    }

    public function deleteUser($userID)
    {
        try {
            $this->authorizeUser($userID);
            $userList = UserList::getInstance();
            $userList->deleteUser($userID);
            $ratingList = RatingList::getInstance();
            $ratingList->deleteAllRatingsByUserID($userID);
            $commentList = CommentList::getInstance();
            $commentList->deleteAllCommentsByUserID($userID);
            $recipeList = RecipeList::getInstance();
            $recipeList->deleteAllRecipesByUserID($userID);
            session_destroy();
            session_unset();
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION["message"] = "user_deleted";
            header("Location: ./index.php");
            exit();
        } catch (InternalUserDataBaseError|InternalRatingDataBaseError|InternalRecipeDataBaseError|InternalCommentDatabaseError $e) {
            $this->handleInternalErrorException();
        } catch (MissingUserException $e) {
            $_SESSION["message"] = "user_not_found";
            header("Location: ./logIn.php");
            exit();
        }
    }

    private function authorizeUser($userID)
    {
        if (!isset($_SESSION["userID"]) || $_SESSION["userID"] != $userID) {
            $_SESSION["message"] = "not_owner_delete_user";
            header("Location: ./profil.php?userID=" . $userID);
            exit();
        }
    }

}