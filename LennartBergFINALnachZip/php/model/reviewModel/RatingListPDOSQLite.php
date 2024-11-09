<?php

if (!isset($abs_path)) {
    require "../../../path.php";
}

require_once $abs_path . "/php/model/Connection.php";
require_once $abs_path . "/php/model/recipeModel/RecipeListDAO.php";
require_once $abs_path . "/php/model/recipeModel/Recipe.php";

class RatingListPDOSQLite implements RatingListDAO
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
            self::$instance = new RatingListPDOSQLite();
        }
        return self::$instance;
    }

    public function addRating($recipeID, $userID, $rating)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "INSERT INTO Ratings (recipeID, userID, rating) VALUES (:recipeID, :userID, :rating)";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID, ":userID" => $userID, ":rating" => $rating])) {
                throw new InternalRatingDataBaseError();
            }
            $this->updateRecipe($recipeID);
            return intval($db->lastInsertId());
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function updateRecipe($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Recipes SET averageRating = :averageRating, ratings = :numberOfRatings WHERE recipeID = :recipeID";
            $averageRating = $this->getAverageRatingByRecipe($recipeID);
            $ratingsCount = count($this->getRatingsByRecipe($recipeID));
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":averageRating" => $averageRating, ":numberOfRatings" => $ratingsCount, ":recipeID" => $recipeID])) {
                throw new InternalRatingDataBaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function getAverageRatingByRecipe($recipeID): float
    {
        try {
            $ratings = $this->getRatingsByRecipe($recipeID);
            $averageRating = array_reduce($ratings, function ($sum, $rating) {
                return $sum + $rating->getRating();
            }, 0);
            return count($ratings) > 0 ? round($averageRating / count($ratings), 2) : 0;

        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function getRatingsByRecipe($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Ratings WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalRatingDataBaseError();
            }
            $result = $command->fetchAll();
            $ratings = [];
            foreach ($result as $row) {
                $ratings[] = new Rating($row["ratingID"], $row["recipeID"], $row["userID"], $row["rating"]);
            }
            return $ratings;
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function getRating($recipeID, $userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Ratings WHERE recipeID = :recipeID AND userID = :userID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID, ":userID" => $userID])) {
                throw new InternalRatingDataBaseError();
            }
            $result = $command->fetch();
            if (!$result) {
                throw new MissingRatingException();
            }
            return $result["rating"];
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function deleteRatingByID($ratingID)
    {
        try {
            $db = $this->connection->getDB();
            $rating = $this->getRatingByID($ratingID);
            $sql = "DELETE FROM Ratings WHERE ratingID = :ratingID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":ratingID" => $ratingID])) {
                throw new InternalRatingDataBaseError();
            }
            $this->updateRecipe($rating->getRecipeID());
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function getRatingByID($ratingID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Ratings WHERE ratingID = :ratingID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":ratingID" => $ratingID])) {
                throw new InternalRatingDataBaseError();
            }
            $result = $command->fetch();
            if (!$result) {
                throw new MissingRatingException();
            }
            return new Rating($result["ratingID"], $result["recipeID"], $result["userID"], $result["rating"]);
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function updateRatingByRatingID($ratingID, $newRating)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Ratings SET rating = :rating WHERE ratingID = :ratingID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":rating" => $newRating, ":ratingID" => $ratingID])) {
                throw new InternalRatingDataBaseError();
            }
            $rating = $this->getRatingByID($ratingID);
            $this->updateRecipe($rating->getRecipeID());
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function updateRating($recipeID, $userID, $rating)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Ratings SET rating = :rating WHERE recipeID = :recipeID AND userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":rating" => $rating, ":recipeID" => $recipeID, ":userID" => $userID])) {
                throw new InternalRatingDataBaseError();
            }
            $this->updateRecipe($recipeID);
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function userHasRatedRecipe($userID, $recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Ratings WHERE userID = :userID AND recipeID = :recipeID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":userID" => $userID, ":recipeID" => $recipeID])) {
                throw new InternalRatingDataBaseError();
            }
            return (bool)$command->fetch();
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }

    public function deleteAllRatingsByUserID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "Select recipeID FROM Ratings WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalRatingDataBaseError();
            }
            $result = $command->fetchAll();
            foreach ($result as $row) {
                try {
                    $this->updateRecipe($row["recipeID"]);
                } catch (InternalRatingDataBaseError $e) {
                    continue;
                }
            }
            $sql = "DELETE FROM Ratings WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRatingDataBaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalRatingDataBaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalRatingDataBaseError();
        }
    }
}

class InternalRatingDataBaseError extends Exception
{
}

?>
