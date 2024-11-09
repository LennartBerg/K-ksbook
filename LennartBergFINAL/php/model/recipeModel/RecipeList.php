<?php

require_once "RecipeListSession.php";
require_once "RecipeListPDOSQLite.php";

class RecipeList
{
    public static function getInstance()
    {
        return RecipeListPDOSQLite::getInstance();
    }
}

?>