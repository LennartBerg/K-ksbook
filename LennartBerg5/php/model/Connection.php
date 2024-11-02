<?php

class Connection
{
    private static ?Connection $instance = null;
    private PDO $db;

    function __construct()
    {
        $user = 'root';
        $pw = null;
        $dsn = 'sqlite:./db/database.db';
        $this->db = new PDO($dsn, $user, $pw);
        $this->checkTables();
    }

    function checkTables()
    {
        $this->checkUsersTable();
        $this->checkCommentsTable();
        $this->checkFavoritesTable();
        $this->checkRecipesTable();
        $this->checkRatingsTable();
    }

    function checkUsersTable()
    {
        $tableName = 'Users';
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->fetch()) {
            $this->buildUsersTable();
        }
    }

    function buildUsersTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS Users (
                userID INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                description TEXT,
                creationDate DATE NOT NULL
            );
        ");
    }

    function checkCommentsTable()
    {
        $tableName = 'Comments';
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->fetch()) {
            $this->buildCommentsTable();
        }
    }

    function buildCommentsTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS Comments (
                commentID INTEGER PRIMARY KEY AUTOINCREMENT,
                text TEXT NOT NULL,
                userID INTEGER NOT NULL,
                recipeID INTEGER NOT NULL,
                creationDate DATE NOT NULL,
                FOREIGN KEY (userID) REFERENCES Users(userID),
                FOREIGN KEY (recipeID) REFERENCES Recipes(recipeID)
            );
        ");
    }

    function checkFavoritesTable()
    {
        $tableName = 'Favorites';
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->fetch()) {
            $this->buildFavoritesTable();
        }
    }

    function buildFavoritesTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS Favorites (
                favoriteID INTEGER PRIMARY KEY AUTOINCREMENT,
                recipeID INTEGER NOT NULL,
                userID INTEGER NOT NULL,
                FOREIGN KEY (recipeID) REFERENCES Recipes(recipeID),
                FOREIGN KEY (userID) REFERENCES Users(userID)
            );
        ");
    }


    function checkRecipesTable()
    {
        $tableName = 'Recipes';
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->fetch()) {
            $this->buildRecipesTable();
        }
    }

    function buildRecipesTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS Recipes (
                recipeID INTEGER PRIMARY KEY AUTOINCREMENT,
                userID INTEGER NOT NULL,
                name TEXT NOT NULL,
                ingredients TEXT NOT NULL,
                instructions TEXT NOT NULL,
                mealType TEXT NOT NULL,
                workTime TEXT NOT NULL,
                dietType TEXT,
                creationDate DATE NOT NULL,
                averageRating TEXT DEFAULT '0',
                ratings TEXT DEFAULT '0',
                picturePath TEXT,
                FOREIGN KEY (userID) REFERENCES Users(userID)
            );
        ");
    }

    function checkRatingsTable()
    {
        $tableName = 'Ratings';
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->fetch()) {
            $this->buildRatingsTable();
        }
    }

    function buildRatingsTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS Ratings (
                ratingID INTEGER PRIMARY KEY AUTOINCREMENT,
                recipeID INTEGER NOT NULL,
                userID INTEGER NOT NULL,
                rating INTEGER CHECK (rating >= 1 AND rating <= 5),
                FOREIGN KEY (recipeID) REFERENCES Recipes(recipeID),
                FOREIGN KEY (userID) REFERENCES Users(userID)
            );
        ");
    }

    public static function getInstance(): Connection
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getDB(): PDO
    {
        return $this->db;
    }

    public function setDB(PDO $db): void
    {
        $this->db = $db;
    }

    function __destruct()
    {
        // Cleanup if necessary
    }
}

?>
