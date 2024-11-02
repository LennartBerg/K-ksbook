<?php

interface CommentListDAO
{
    public function newComment($text, $userID, $recipeID);

    public function getCommentByID($commentID);

    public function deleteComment($commentID);

    public function getAllCommentsByRecipe($recipeID);

    public function getCommentsByUser($userID);

}

class InternalErrorException extends Exception
{
}

class MissingCommentException extends Exception
{
}

?>