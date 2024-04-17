<?php

namespace App\Authentication\Domain\Models;

use App\Authentication\Domain\Models\ValueObjects\UserBirthDate;
use App\Authentication\Domain\Models\ValueObjects\UserEmail;
use App\Authentication\Domain\Models\ValueObjects\UserId;
use App\Authentication\Domain\Models\ValueObjects\UserImage;
use App\Authentication\Domain\Models\ValueObjects\UserName;
use App\Authentication\Domain\Models\ValueObjects\UserPassword;
use App\Authentication\Domain\Models\ValueObjects\UserToken;
use App\Authentication\Domain\Models\ValueObjects\UserUsername;
use DateTime;

class User
{
    private UserId $id;
    private UserName $name;
    private UserUsername $userName;
    private UserEmail $email;
    private UserPassword $password;
    private UserBirthDate $birthDate;
    private UserImage $image;

    public function __construct(
        int $id,
        string $name,
        string $userName,
        string $email,
        string $password,
        DateTime $birthDate,
        string $image,
    )
    {
        $this->id = new UserId($id);
        $this->name = new UserName($name);
        $this->userName = new UserUsername($userName);
        $this->email = new UserEmail($email);
        $this->password = new UserPassword($password);
        $this->birthDate = new UserBirthDate($birthDate);
        $this->image = new UserImage($image);
    }

    public function updateName(string $name): void
    {
        $this->name = new UserName($name);
    }

    public function updateUserName(string $userName): void
    {
        $this->userName = new UserUsername($userName);
    }

    public function updateEmail(string $email): void
    {
        $this->email = new UserEmail($email);
    }

    public function updatePassword(string $password): void
    {
        $this->password = new UserPassword($password);
    }

    public function updateBirthDate(DateTime $birthDate): void
    {
        $this->birthDate = new UserBirthDate($birthDate);
    }

    public function updateImage(string $image): void
    {
        $this->image = new UserImage($image);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getUsername(): UserUsername
    {
        return $this->userName;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    public function getImage(): UserImage
    {
        return $this->image;
    }
}
