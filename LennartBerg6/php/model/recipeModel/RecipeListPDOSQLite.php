<?php

if (!isset($abs_path)) {
    require "../../../path.php";
}

require_once $abs_path . "/php/model/Connection.php";
require_once $abs_path . "/php/model/recipeModel/RecipeListDAO.php";
require_once $abs_path . "/php/model/recipeModel/Recipe.php";

class RecipeListPDOSQLite implements RecipeListDAO
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
            self::$instance = new RecipeListPDOSQLite();
        }
        return self::$instance;
    }

    public function newRecipe($userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType, $picturePath)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "INSERT INTO Recipes (userID, name, ingredients, instructions, mealType, workTime, dietType, picturePath, creationDate) 
                    VALUES (:userID, :name, :ingredients, :instructions, :mealType, :workTime, :dietType, :picturePath, date('now'))";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([
                ":userID" => $userID,
                ":name" => $name,
                ":ingredients" => $ingredients,
                ":instructions" => $instructions,
                ":mealType" => $mealType,
                ":workTime" => $workTime,
                ":dietType" => $dietType,
                ":picturePath" => $picturePath
            ])) {
                throw new InternalRecipeDataBaseError();
            }
            return intval($db->lastInsertId());
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipe($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes WHERE recipeID = :recipeID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetch();
            if (!$result) {
                $_SESSION["message"] = "recipe_not_found";
                header("Location: ./index.php");
                exit();
            }
            $recipe = $this->getRecipe1($result);
            return $recipe;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    /**
     * @param $row
     * @return Recipe
     */
    public function getRecipe1($row): Recipe
    {
        $recipe = new Recipe($row["recipeID"], $row["userID"], $row["name"], $row["ingredients"], $row["instructions"], $row["mealType"], $row["workTime"], $row["dietType"], $row["picturePath"]);
        $creationDate = $row["creationDate"];
        $averageRating = $row["averageRating"];
        $ratings = $row["ratings"];
        $recipe->setCreationDate($creationDate);
        $recipe->setAverageRating($averageRating);
        $recipe->setRatings($ratings);
        return $recipe;
    }

    public function deleteRecipe($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Recipes WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalRecipeDataBaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function updateRecipe($recipeID, $userID, $name, $ingredients, $instructions, $mealType, $workTime, $dietType)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "UPDATE Recipes SET userID = :userID, name = :name, ingredients = :ingredients, instructions = :instructions, 
                    mealType = :mealType, workTime = :workTime, dietType = :dietType WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([
                ":userID" => $userID,
                ":name" => $name,
                ":ingredients" => $ingredients,
                ":instructions" => $instructions,
                ":mealType" => $mealType,
                ":workTime" => $workTime,
                ":dietType" => $dietType,
                ":recipeID" => $recipeID
            ])) {
                throw new InternalRecipeDataBaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipes()
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute()) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetchAll();
            $recipes = [];
            foreach ($result as $row) {
                $recipe = $this->getRecipe1($row);
                $recipes[] = $recipe;
            }
            return $recipes;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipesByMealType($mealType)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes WHERE mealType = :mealType";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":mealType" => $mealType])) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetchAll();
            $recipes = [];
            foreach ($result as $row) {
                $recipe = $this->getRecipe1($row);
                $recipes[] = $recipe;
            }
            return $recipes;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipesByMaxTime($maxTime)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes WHERE workTime <= :maxTime";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":maxTime" => $maxTime])) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetchAll();
            $recipes = [];
            foreach ($result as $row) {
                $recipe = $this->getRecipe1($row);
                $recipes[] = $recipe;
            }
            return $recipes;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipesByDietType($dietType)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes WHERE dietType = :dietType";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":dietType" => $dietType])) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetchAll();
            $recipes = [];
            foreach ($result as $row) {
                $recipe = $this->getRecipe1($row);
                $recipes[] = $recipe;
            }
            return $recipes;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function getRecipesByUser($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Recipes WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalRecipeDataBaseError();
            }
            $result = $command->fetchAll();
            $recipes = [];
            foreach ($result as $row) {
                $recipe = $this->getRecipe1($row);
                $recipes[] = $recipe;
            }
            return $recipes;
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }

    public function deleteAllRecipesByUserID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Recipes WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalRecipeDataBaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalRecipeDataBaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalRecipeDataBaseError();
        }
    }
}

class InternalRecipeDataBaseError extends Exception
{
}

?>
