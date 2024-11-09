<?php
require_once "RatingListSession.php";
require_once "RatingListPDOSQLite.php";

class RatingList
{
    public static function getInstance()
    {
        return RatingListPDOSQLite::getInstance();
    }
}

?>