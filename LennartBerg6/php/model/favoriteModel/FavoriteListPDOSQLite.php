<?php

if (!isset($abs_path)) {
    require "../../../path.php";
}

require_once $abs_path . "/php/model/Connection.php";
require_once $abs_path . "/php/model/favoriteModel/FavoriteListDAO.php";
require_once $abs_path . "/php/model/favoriteModel/Favorite.php";


class FavoriteListPDOSQLite implements FavoriteListDAO
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
            self::$instance = new FavoriteListPDOSQLite();
        }
        return self::$instance;
    }

    public function newFavorite($userID, $recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "INSERT INTO Favorites (userID, recipeID) VALUES (:userID, :recipeID)";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":userID" => $userID, ":recipeID" => $recipeID])) {
                throw new InternalFavoriteDatabaseError();
            }
            return intval($db->lastInsertId());
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function getFavoriteByID($favoriteID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Favorites WHERE favoriteID = :favoriteID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":favoriteID" => $favoriteID])) {
                throw new InternalFavoriteDatabaseError();
            }
            $result = $command->fetch();
            if (!$result) {
                throw new MissingFavoriteException();
            }
            return new Favorite($result["favoriteID"], $result["userID"], $result["recipeID"]);
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function deleteFavorite($favoriteID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Favorites WHERE favoriteID = :favoriteID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":favoriteID" => $favoriteID])) {
                throw new InternalFavoriteDatabaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function getAllFavoritesByUserID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT recipeID FROM Favorites WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalFavoriteDatabaseError();
            }
            return $command->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function getAllFavoritesByRecipeID($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Favorites WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalFavoriteDatabaseError();
            }
            return $command->fetchAll(PDO::FETCH_CLASS, "Favorite");
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function deleteAllFavoritesByUserID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Favorites WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalFavoriteDatabaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function deleteAllFavoritesByRecipeID($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Favorites WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalFavoriteDatabaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }

    public function getAllFavorites()
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Favorites";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalFavoriteDatabaseError();
            }
            if (!$command->execute()) {
                throw new InternalFavoriteDatabaseError();
            }
            return $command->fetchAll(PDO::FETCH_CLASS, "Favorite");
        } catch (PDOException $exc) {
            throw new InternalFavoriteDatabaseError();
        }
    }
}

class InternalFavoriteDatabaseError extends Exception
{
}

?>
