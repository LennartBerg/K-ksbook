<?php

if (!isset($abs_path)) {
    require_once "../../../path.php";
}

require_once $abs_path . "/php/model/commentModel/CommentListDAO.php";
require_once $abs_path . "/php/model/commentModel/Comment.php";


class CommentListSession implements CommentListDAO
{
    private static $instance = null;

    private $comments = array();

    private function __construct()
    {
        if (isset($_SESSION["comments"])) {
            $this->comments = unserialize($_SESSION["comments"]);
        } else {
            $this->comments[0] = new Comment(0, "Comment 1 sample text blablabla", 1, 0);
            $this->comments[1] = new Comment(1, "Comment 2 sample text blablabla", 1, 1);
            $this->comments[2] = new Comment(2, "Comment 3 sample text blablabla", 1, 2);
            $this->comments[3] = new Comment(3, "Comment 4 sample text blablabla", 1, 0);
            $this->comments[4] = new Comment(4, "Comment 5 sample text blablabla", 1, 1);
            $this->comments[5] = new Comment(5, "Comment 6 sample text blablabla", 1, 2);
            $_SESSION["entries"] = serialize($this->comments);
            $_SESSION["nextId"] = 6;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CommentListSession();
        }
        return self::$instance;
    }

    public function newComment($text, $userID, $recipeID)
    {
        $this->comments[$_SESSION["nextId"]] = new Comment($_SESSION["nextId"], $text, $userID, $recipeID);
        $_SESSION["nextId"] = $_SESSION["nextId"] + 1;
        $_SESSION["comments"] = serialize($this->comments);
    }

    public function getCommentByID($commentID)
    {
        foreach ($this->comments as $comment) {
            if ($comment->getCommentID() == $commentID) {
                return $comment;
            }
        }
        throw new MissingCommentException();
    }

    public function deleteComment($commentID)
    {
        foreach ($this->comments as $comment) {
            if ($comment->getCommentID() == $commentID) {
                unset($this->comments[$commentID]);
                $_SESSION["comments"] = serialize($this->comments);
                return;
            }
        }
        throw new MissingCommentException();
    }

    public function getAllCommentsByRecipe($recipeID)
    {
        $commentsByRecipe = array();
        foreach ($this->comments as $comment) {
            if ($comment->getRecipeID() == $recipeID) {
                $commentsByRecipe[] = $comment;
            }
        }
        return $commentsByRecipe;
    }

    public function getCommentsByUser($userID)
    {
        $commentsByUser = array();
        foreach ($this->comments as $comment) {
            if ($comment->getErsteller() == $userID) {
                $commentsByUser[] = $comment;
            }
        }
        return $commentsByUser;
    }
}

?>