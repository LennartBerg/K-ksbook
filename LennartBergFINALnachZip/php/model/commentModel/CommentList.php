<?php
require_once "CommentListSession.php";
require_once "CommentListPDOSQLite.php";

class CommentList
{
    public static function getInstance()
    {
        return CommentListPDOSQLite::getInstance();
    }
}

?>