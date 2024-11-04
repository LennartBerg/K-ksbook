<?php

if (!isset($abs_path)) {
    require_once "../../../path.php";
}

require_once $abs_path . "/php/model/userModel/UserListDAO.php";
require_once $abs_path . "/php/model/userModel/User.php";

class UserListSession implements UserListDAO
{
    private static $instance = null;

    private $users = array();

    private function __construct()
    {
        if (isset($_SESSION["users"])) {
            $this->users = unserialize($_SESSION["users"]);
        } else {
            $this->users[0] = new User(0, "User 1", "password1", "email1@test.de", "Description 1. Make it long enough to see how the text is displayed in the browser.");
            $this->users[1] = new User(1, "User 2", "password2", "email2@test.de", "Description 2. Make it long enough to see how the text is displayed in the browser.");
            $this->users[2] = new User(2, "User 3", "password3", "email3@test.de", "Description 3. Make it long enough to see how the text is displayed in the browser.");
            $_SESSION["users"] = serialize($this->users);
            $_SESSION["nextId"] = 3;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserListSession();
        }
        return self::$instance;
    }

    public function newUser($username, $password, $email, $description)
    {
        //check if email already exists
        foreach ($this->users as $u) {
            if ($u->getEmail() == $email) {
                throw new EmailAlreadyInUseException("Email already exists");
            }
        }

        //check if username already exists
        foreach ($this->users as $u) {
            if ($u->getUsername() == $username) {
                throw new UsernameAlreadyInUseException("Username already exists");
            }
        }

        //create new user
        $this->users[$_SESSION["nextId"]] = new User($_SESSION["nextId"], $username, $password, $email, $description);
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $_SESSION["users"] = serialize($this->users);
    }

    public function getUserByID($userID)
    {
        foreach ($this->users as $u) {
            if ($u->getUserID() == $userID) {
                return $u;
            }
        }
        throw new MissingUserException("User not found");
    }

    public function deleteUserByID($userID)
    {
        foreach ($this->users as $key => $u) {
            if ($u->getUserID() == $userID) {
                unset($this->users[$key]);
                $_SESSION["users"] = serialize($this->users);
                return;
            }
        }
        throw new MissingUserException("User not found");
    }

    public function updateUserDescription($userID, $description)
    {
        foreach ($this->users as $u) {
            if ($u->getUserID() == $userID) {
                $u->setDescription($description);
                $_SESSION["users"] = serialize($this->users);
                return;
            }
        }
        throw new MissingUserException("User not found");
    }

    public function getAllUsers()
    {
        return $this->users;
    }

    public function getUserByEmail($email)
    {
        foreach ($this->users as $u) {
            if ($u->getEmail() == $email) {
                return $u;
            }
        }
        return null;
    }

    public function getUserByName($name)
    {
        foreach ($this->users as $u) {
            if ($u->getUsername() == $name) {
                return $u;
            }
        }
        return null;
    }
}

?>
