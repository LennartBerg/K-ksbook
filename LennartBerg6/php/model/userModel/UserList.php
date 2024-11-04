<?php

require_once "UserListSession.php";
require_once "UserListPDOSQLite.php";

class UserList
{
    public static function getInstance()
    {
        return UserListPDOSQLite::getInstance();
    }
}

?>
