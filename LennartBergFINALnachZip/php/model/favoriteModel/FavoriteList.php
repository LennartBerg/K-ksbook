<?php
require_once "FavoriteListSession.php";
require_once "FavoriteListPDOSQLite.php";

class FavoriteList
{
    public static function getInstance()
    {
        return FavoriteListPDOSQLite::getInstance();
    }
}

?>