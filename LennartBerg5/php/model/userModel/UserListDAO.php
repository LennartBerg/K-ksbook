<?php

interface userListDAO
{
    public function newUser($username, $password, $email, $description);

    public function getUserByID($userID);

    public function deleteUserByID($userID);

    public function updateUserDescription($userID, $description);

    public function getAllUsers();
}

class MissingUserException extends Exception
{
}

class EmailAlreadyInUseException extends Exception
{
}

class UsernameAlreadyInUseException extends Exception
{
}

?>
