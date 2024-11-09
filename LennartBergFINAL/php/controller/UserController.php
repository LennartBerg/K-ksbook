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
        $email = $_POST["email"];
        $_SESSION['Form_logIn']['email'] = $email;
        $this->checkInput();
        $this->checkAccountactivation($email);
        $this->checkUser();
        $this->setSession();
        unset($_SESSION['Form_LogIn']);
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

    private function checkAccountactivation($email)
    {
        $userList = UserList::getInstance();
        try {
            $user = $userList->getUserByEmail($email);
            if (($user != null) && $user->isActivated() == 0) {
                file_put_contents("./php/controller/verification/" . $email . ".txt", "Someone tried to log in to your account. If this was you, please activate your account first. Just re-register with your mail and you'll get a new Code." . "\n\n\n" . "Please ignore this email if you did not attempt to register.");
                $this->handleInvalidLoginException();
            }
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    private function handleInvalidLoginException()
    {
        $_SESSION["message"] = "invalid_login";
        $_SESSION['Form_LogIn']["email"] = htmlspecialchars($_POST["email"]);
        header("Location: ./logIn.php");
        exit;
    }

    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: index.php");
        exit;
    }

    private function checkUser()
    {
        $userList = UserList::getInstance();

        $user = $userList->getUserByEmail(htmlspecialchars($_POST["email"]));
        if ($user === null || !password_verify($_POST["password"], $user->getHashedPassword())) {
            $this->handleInvalidLoginException();
        }
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
        $this->checkPassword();
        $_SESSION["account_to_activate"] = $_POST["email"];
        try {
            $_SESSION["confirmation_code"] = bin2hex(random_bytes(20));
        } catch (Exception $e) {
            $this->handleInternalErrorException();
        }
        $this->checkExistingUser();
        $this->createUser();
        $_SESSION['filepath'] = "verification/" . $_POST["email"] . ".txt";
        $_SESSION["message"] = "new_user_not_activated";
        unset($_SESSION['Form_Register']);
        header("Location: ./confirm.php");
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

    public function checkExistingUser()
    {
        try {
            $userList = UserList::getInstance();
            $user = $userList->getUserByEmail($_POST["email"]);

            if ($user !== null) {
                if ($user->isActivated() == 0) {
                    file_put_contents("./php/controller/verification/" . $_POST["email"] . ".txt", "Welcome to Köksbook! An Account with this mail has already been created, yet never been activated. Your new activation code is: " . $_SESSION["confirmation_code"] . "\n\n\n" . "Please ignore this email if you did not attempt to register. \n\n\n Someone might have just entered your email address by mistake.");

                } else {
                    file_put_contents("./php/controller/verification/" . $_POST["email"] . ".txt", "Welcome back to Köksbook! You are already registered!\n\n\n" . "Please ignore this email if you did not attempt to register.\n\n\n" . "If you have forgotten your password, you can request a new one on the login page.");
                }
                $_SESSION['filepath'] = "verification/" . $_POST["email"] . ".txt";
                $_SESSION["message"] = "new_user_not_activated";
                unset($_SESSION['Form_Register']);
                header("Location: ./confirm.php");
                exit;
            } else {
                file_put_contents("./php/controller/verification/" . $_POST["email"] . ".txt", "Welcome to Köksbook! Your activation code is: " . $_SESSION["confirmation_code"] . "\n\n\n" . "Please ignore this email if you did not attempt to register. \n\n\n Someone might have just entered your email address by mistake.");
            }
        } catch (InternalUserDataBaseError $exc) {
            $this->handleInternalErrorException();
        }
    }

    public function createUser()
    {
        try {
            $userList = UserList::getInstance();
            $userList->newUser(htmlspecialchars($_POST["name"]), password_hash($_POST["password"], PASSWORD_DEFAULT), htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["description"]));
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

    public function verifyAccount($code)
    {
        if ($code == $_SESSION["confirmation_code"]) {
            try {
                $userList = UserList::getInstance();
                $userList->activateUser($_SESSION["account_to_activate"]);
                $_SESSION["message"] = "new_user_activated";
                header("Location: ./logIn.php");
                exit();
            } catch (InternalUserDataBaseError $e) {
                $this->handleInternalErrorException();
            }
        } else if ($code == $_SESSION["password_reset_code"]) {
            $_SESSION["message"] = "password_reset";
            try {
                $this->checkNewPasswords($_SESSION['password'], $_SESSION['passwordRepeat']);
                $userList = UserList::getInstance();
                $user = $userList->getUserByEmail($_SESSION["password_reset_account"]);
                $userList->updateUserPassword($user->getUserID(), password_hash($_POST["password"], PASSWORD_DEFAULT));
                unset($_SESSION["password_reset_account"]);
                unset($_SESSION["password_reset_code"]);
                unset($_SESSION['password']);
                unset($_SESSION['password_repeat']);
                $_SESSION["message"] = "password_reset";
                header("Location: ./logIn.php");
                exit();
            } catch (InternalUserDataBaseError $e) {
                $this->handleInternalErrorException();
            } catch (MissingUserException $e) {
                $_SESSION["message"] = "user_not_found";
                header("Location: ./logIn.php");
                exit();
            }
            header("Location: ./newPassword.php");
            exit();
        } else {
            $_SESSION["message"] = "invalid_code";
            header("Location: ./confirm.php");
            exit();
        }
    }

    private function checkNewPasswords($password, $password_repeat)
    {
        if ($password != $password_repeat) {
            $_SESSION["message"] = "invalid_password_reset";
            header("Location: ./newPassword.php");
            exit();
        }
    }

    public function resetPassword($email)
    {
        try {
            $userList = UserList::getInstance();
            $user = $userList->getUserByEmail($email);
            $_SESSION["password_reset_account"] = $email;
            $_SESSION["password_reset_code"] = bin2hex(random_bytes(20));
            if ($user == null) {
                header("Location: ./newPassword.php");
                exit();
            }
            file_put_contents("./php/controller/verification/pw" . $email . ".txt", "Someone tried to reset your password. If this was you, please enter the following code on the website: " . $_SESSION["password_reset_code"] . "\n\n\n" . "Please ignore this email if you did not attempt to reset your password.");
            $_SESSION['filepath'] = "verification/pw" . $_POST["email"] . ".txt";
            header("Location: ./newPassword.php");
            exit();
        } catch (InternalUserDataBaseError $e) {
            $this->handleInternalErrorException();
        } catch (Exception $e) {
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

}