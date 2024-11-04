<?php

if (!isset($abs_path)) {
    require "../../../path.php";
}

require_once $abs_path . "/php/model/Connection.php";
require_once $abs_path . "/php/model/commentModel/CommentListDAO.php";
require_once $abs_path . "/php/model/commentModel/Comment.php";


class CommentListPDOSQLite implements CommentListDAO
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
            self::$instance = new CommentListPDOSQLite();
        }
        return self::$instance;
    }

    public function newComment($text, $userID, $recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "INSERT INTO Comments (text, userID, recipeID, creationDate) VALUES (:text, :userID, :recipeID, date('now'))";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":text" => $text, ":userID" => $userID, ":recipeID" => $recipeID])) {
                throw new InternalCommentDatabaseError();
            }
            return intval($db->lastInsertId());
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }

    public function getCommentByID($commentID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Comments WHERE commentID = :commentID LIMIT 1";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":commentID" => $commentID])) {
                throw new InternalCommentDatabaseError();
            }
            $result = $command->fetch();
            if (!$result) {
                throw new MissingCommentException();
            }
            return new Comment($result["commentID"], $result["text"], $result["userID"], $result["recipeID"]);
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }

    public function deleteComment($commentID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Comments WHERE commentID = :commentID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":commentID" => $commentID])) {
                throw new InternalCommentDatabaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }

    public function getAllCommentsByRecipe($recipeID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Comments WHERE recipeID = :recipeID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":recipeID" => $recipeID])) {
                throw new InternalCommentDatabaseError();
            }
            $result = $command->fetchAll();
            $comments = [];
            foreach ($result as $row) {
                $comments[] = new Comment($row["commentID"], $row["text"], $row["userID"], $row["recipeID"]);
            }
            return $comments;
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }

    public function getCommentsByUser($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "SELECT * FROM Comments WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalCommentDatabaseError();
            }
            $result = $command->fetchAll();
            $comments = [];
            foreach ($result as $row) {
                $comments[] = new Comment($row["commentID"], $row["text"], $row["userID"], $row["recipeID"]);
            }
            return $comments;
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }

    public function deleteAllCommentsByUserID($userID)
    {
        try {
            $db = $this->connection->getDB();
            $sql = "DELETE FROM Comments WHERE userID = :userID";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalCommentDatabaseError();
            }
            if (!$command->execute([":userID" => $userID])) {
                throw new InternalCommentDatabaseError();
            }
        } catch (PDOException $exc) {
            throw new InternalCommentDatabaseError();
        }
    }
}

class InternalCommentDatabaseError extends Exception
{
}

?>
