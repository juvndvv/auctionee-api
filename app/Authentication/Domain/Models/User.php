<?php

namespace App\Authentication\Domain\Models;

use App\Authentication\Domain\Models\ValueObjects\UserBirthDate;
use App\Authentication\Domain\Models\ValueObjects\UserEmail;
use App\Authentication\Domain\Models\ValueObjects\UserId;
use App\Authentication\Domain\Models\ValueObjects\UserImage;
use App\Authentication\Domain\Models\ValueObjects\UserName;
use App\Authentication\Domain\Models\ValueObjects\UserPassword;
use App\Authentication\Domain\Models\ValueObjects\UserUsername;
use DateTime;
use Illuminate\Support\Facades\Date;

// Todo: publicar eventos
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
        Date $birthDate,
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

    public static function fromArray(array $data): User
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['birthDate'],
            $data['image']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'username' => $this->userName->value(),
            'email' => $this->email->value(),
            'password' => $this->password->value(),
            'birth_date' => $this->birthDate->value(),
            'image_url' => $this->image->value(),
        ];
    }

    public static function create(array $data): User {
        return User::fromArray($data);
    }

    public function delete(): void
    {
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

    public function getId(): int
    {
        return $this->id->value();
    }

    public function getName(): string
    {
        return $this->name->value();
    }

    public function getUsername(): string
    {
        return $this->userName->value();
    }

    public function getEmail(): string
    {
        return $this->email->value();
    }

    public function getPassword(): string
    {
        return $this->password->value();
    }

    public function getBirthDate(): Date
    {
        return $this->birthDate->value();
    }

    public function getImage(): string
    {
        return $this->image->value();
    }
}
