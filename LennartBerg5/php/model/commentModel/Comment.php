<?php

class Comment
{
    private int $commentID;
    private string $text;
    private string $userID;
    private int $recipeID;
    private string $creationDate;

    public function __construct($commentID, $text, $userID, $recipeID)
    {
        $this->commentID = $commentID;
        $this->text = $text;
        $this->userID = $userID;
        $this->recipeID = $recipeID;
        $this->creationDate = date("d-m-Y");
    }

    public function getReviewID(): int
    {
        return $this->reviewID;
    }

    public function setReviewID($reviewID): void
    {
        $this->reviewID = $reviewID;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getUserID(): string
    {
        return $this->userID;
    }

    public function setUserID(string $ersteller): void
    {
        $this->userID = $ersteller;
    }

    public function getRecipeID(): int
    {
        return $this->recipeID;
    }

    public function setRecipeID($recipeID): void
    {
        $this->recipeID = $recipeID;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    public function getCommentID(): int
    {
        return $this->commentID;
    }

    public function setCommentID(int $commentID): void
    {
        $this->commentID = $commentID;
    }
}

?>