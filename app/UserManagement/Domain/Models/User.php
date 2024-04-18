<?php

namespace App\UserManagement\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Events\UserDeletedEvent;
use App\UserManagement\Domain\Events\UserUpdatedEvent;
use App\UserManagement\Domain\Models\ValueObjects\UserEmail;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use App\UserManagement\Domain\Models\ValueObjects\UserName;
use App\UserManagement\Domain\Models\ValueObjects\UserPassword;
use App\UserManagement\Domain\Models\ValueObjects\UserUsername;

class User extends AggregateRoot
{
    private UserId $id;
    private UserName $name;
    private UserUsername $username;
    private UserEmail $email;
    private UserPassword $password;

    public function __construct(string $id, string $name, string $username, string $email, string $password)
    {
        $this->id = new UserId($id);
        $this->name = new UserName($name);
        $this->username = new UserUsername($username);
        $this->email = new UserEmail($email);
        $this->password = new UserPassword($password);
    }

    public static function create($name, $username, $email, $password): User
    {
        $generatedId = UserId::random();
        $user = new self(
            $generatedId,
            $name,
            $username,
            $email,
            $password
        );
        $user->record(new UserCreatedEvent($generatedId, $name, $username, $email, $password));
        return $user;
    }

    public function updateName(string $new): void
    {
        $old = $this->name->value();
        $this->name = new UserName($new);
        $this->record(new UserUpdatedEvent($this->id(), "UserName", $new, $old));
    }

    public function updateUsername(string $new): void
    {
        $old = $this->username->value();
        $this->username = new UserUsername($new);
        $this->record(new UserUpdatedEvent($this->id(), "UserUsername",$new, $old));
    }

    public function updateEmail(string $new): void
    {
        $old = $this->email->value();
        $this->email = new UserEmail($new);
        $this->record(new UserUpdatedEvent($this->id(), "UserEmail", $new, $old));
    }

    public function updatePassword(string $new): void
    {
        $old = $this->password->value();
        $this->password = new UserPassword($new);
        $this->record(new UserUpdatedEvent($this->id(), "UserPassword", $new, $old));
    }

    public function delete(): void
    {
        $this->record(new UserDeletedEvent($this->id));
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function username(): string
    {
        return $this->username->value();
    }

    public function email(): string
    {
        return $this->email->value();
    }

    public function password(): string
    {
        return $this->password->value();
    }
}
