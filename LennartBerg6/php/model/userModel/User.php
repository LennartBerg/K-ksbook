<?php

class User
{
    private int $userID;

    private string $username;

    private string $password;

    private string $email;

    private string $description;

    private string $creationDate;

    private bool $activated = false;

    public function __construct($userID, $username, $password, $email, $description, $activated)
    {
        $this->username = $username;
        // Hash password
        $this->password = $password;
        $this->email = $email;
        $this->description = $description;
        $this->userID = $userID;
        $this->creationDate = date("d-m-Y");
        $this->activated = $activated;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate(string $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    public function checkPassword($password): bool
    {
        return $this->password == $password;
    }

    public function getHashedPassword(): string
    {
        return $this->password;
    }

    public function isActivated(): bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): void
    {
        $this->activated = $activated;
    }
}

?>