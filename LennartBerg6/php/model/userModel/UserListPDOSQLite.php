<?php

if (!isset($abs_path)) {
    require "../../../path.php";
}

require_once $abs_path . "/php/model/Connection.php";
require_once $abs_path . "/php/model/userModel/UserListDAO.php";
require_once $abs_path . "/php/model/userModel/User.php";


class UserListPDOSQLite implements UserListDAO
{

    private static $instance = null;
    private Connection $connection;

    private function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new UserListPDOSQLite();
        }
        return self::$instance;
    }

    public function newUser($username, $password, $email, $description)
    {
        try {
            $db = $this->connection->getDB();

            // Check if email already exists
            $sql = "SELECT COUNT(*) FROM Users WHERE email = :email";
            $command = $db->prepare($sql);
            $command->execute([":email" => $email]);
            if ($command->fetchColumn() > 0) {
                throw new EmailAlreadyInUseException("Email already exists");
            }


            // Create new user
            $sql = "INSERT INTO Users (username, password, email, description, creationDate) VALUES (:username, :password, :email, :description, date('now'))";
            $command = $db->prepare($sql);
            $command->execute([":username" => $username, ":password" => $password, ":email" => $email, ":description" => $description]);

            return intval($db->lastInsertId());
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function getUserByID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Users WHERE userID = :userID LIMIT 1";
            $command = $db->prepare($sql);
            $command->execute([":userID" => $userID]);
            $result = $command->fetch();
            if (!$result) {
                $_SESSION["message"] = "user_not_found";
                header("Location: ./index.php");
                exit();
            }
            return new User($result["userID"], $result["username"], $result["password"], $result["email"], $result["description"], $result["confirmed"]);
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function deleteUserByID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Users WHERE userID = :userID";
            $command = $db->prepare($sql);
            $command->execute([":userID" => $userID]);
            if ($command->rowCount() == 0) {
                $_SESSION["message"] = "user_not_found";
                header("Location: ./index.php");
                exit();
            }
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function updateUserDescription($userID, $description)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Users SET description = :description WHERE userID = :userID";
            $command = $db->prepare($sql);
            $command->execute([":description" => $description, ":userID" => $userID]);
            if ($command->rowCount() == 0) {
                throw new MissingUserException("User not found");
            }
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function getAllUsers()
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Users";
            $command = $db->prepare($sql);
            $command->execute();
            $result = $command->fetchAll();
            $users = [];
            foreach ($result as $row) {
                $users[] = new User($row["userID"], $row["username"], $row["password"], $row["email"], $row["description"], $result["confirmed"]);
            }
            return $users;
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Users WHERE email = :email LIMIT 1";
            $command = $db->prepare($sql);
            $command->execute([":email" => $email]);
            $result = $command->fetch();
            if (!$result) {
                return null;
            }
            return new User($result["userID"], $result["username"], $result["password"], $result["email"], $result["description"], $result["confirmed"]);
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function getUserByName($name)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1";
            $command = $db->prepare($sql);
            $command->execute([":username" => $name]);
            $result = $command->fetch();
            if (!$result) {
                return null;
            }
            return new User($result["userID"], $result["username"], $result["password"], $result["email"], $result["description"], $result["confirmed"]);
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function deleteUser($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Users WHERE userID = :userID";
            $command = $db->prepare($sql);
            $command->execute([":userID" => $userID]);
            if ($command->rowCount() == 0) {
                throw new MissingUserException("User not found");
            }
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function activateUser($email)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Users
                    SET confirmed  = true
                    WHERE email = :email";
            $command = $db->prepare($sql);
            $command->execute([":email" => $email]);
            if ($command->rowCount() == 0) {
                throw new MissingUserException("User not found");
            }
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }

    public function updateUserPassword(int $userID, $password)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Users SET password = :password WHERE userID = :userID";
            $command = $db->prepare($sql);
            $command->execute([":password" => $password, ":userID" => $userID]);
            if ($command->rowCount() == 0) {
                throw new MissingUserException("User not found");
            }
        } catch (PDOException $exc) {
            throw new InternalUserDataBaseError();
        }
    }
}

class InternalUserDataBaseError extends Exception
{
}

?>
