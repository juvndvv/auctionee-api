<?php

namespace App\UserManagement\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Models\ValueObjects\UserBirth;
use App\UserManagement\Domain\Models\ValueObjects\UserEmail;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use App\UserManagement\Domain\Models\ValueObjects\UserAvatar;
use App\UserManagement\Domain\Models\ValueObjects\UserName;
use App\UserManagement\Domain\Models\ValueObjects\UserPassword;
use App\UserManagement\Domain\Models\ValueObjects\UserRole;
use App\UserManagement\Domain\Models\ValueObjects\UserUsername;

class User extends AggregateRoot
{
    private UserId $id;
    private UserName $name;
    private UserUsername $username;
    private UserEmail $email;
    private UserPassword $password;
    private UserAvatar $avatar;
    private UserBirth $birth;

    private UserRole $role;

    public function __construct(
        string $uuid,
        string $name,
        string $username,
        string $email,
        string $password,
        string $avatar,
        string $birth,
        int $role
    ) {
        $this->id = new UserId($uuid);
        $this->name = new UserName($name);
        $this->username = new UserUsername($username);
        $this->email = new UserEmail($email);
        $this->password = $password === "" ? new UserPassword($password) : new UserPassword("123");
        $this->avatar = new UserAvatar($avatar);
        $this->birth = new UserBirth($birth);
        $this->role = new UserRole($role);
    }

    public static function create($name, $username, $email, $password, $avatar, $birth, $role): User
    {
        $generatedId = UserId::random();
        $user = new self(
            $generatedId,
            $name,
            $username,
            $email,
            $password,
            $avatar,
            $birth,
            $role
        );
        $user->record(new UserCreatedEvent($generatedId, $name, $username, $email, $password));
        return $user;
    }

    public static function fromPrimitives(array $data): User
    {
        return new self(
            $data['uuid'],
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['avatar'],
            $data['birth'],
            $data['role']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'uuid' => $this->id->value(),
            'name' => $this->name->value(),
            'username' => $this->username->value(),
            'email' => $this->email->value(),
            'password' => $this->password->value(),
            'avatar' => $this->avatar->value(),
            'birth' => $this->birth->value(),
            'role' => $this->role->value(),
        ];
    }

    public function updateAvatar(string $new): void
    {
        $old = $this->avatar->value();
        $this->avatar = new UserAvatar($new);
        //$this->record(new UserUpdatedEvent($this->id, "UserAvatar", $new, $old));
    }

    public function updateName(string $new): void
    {
        $old = $this->name->value();
        $this->name = new UserName($new);
        //$this->record(new UserUpdatedEvent($this->id, "user.name", $new, $old));
    }

    public function updateUsername(string $new): void
    {
        $old = $this->username->value();
        $this->username = new UserUsername($new);
        //$this->record(new UserUpdatedEvent($this->id, "user.username", $new, $old));
    }

    public function updateEmail(string $new): void
    {
        $old = $this->email->value();
        $this->email = new UserEmail($new);
        //$this->record(new UserUpdatedEvent($this->id(), "user.email", $new, $old));
    }

    public function updatePassword(string $new): void
    {
        $old = $this->password->value();
        $this->password = new UserPassword($new);
        //$this->record(new UserUpdatedEvent($this->id, "user.password", $new, $old));
    }

    public function delete(): void
    {
        //$this->record(new UserDeletedEvent($this->id));
    }

    public function block(): void
    {
        $this->role = new UserRole(2);
    }

    public function unblock(): void
    {
        $this->role = new UserRole(0);
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

    public function avatar(): string
    {
        return $this->avatar->value();
    }

    public function role(): string
    {
        return match ($this->role()) {
            1 => "ADMIN",
            2 => "BLOCKED",
            default => "USER",
        };
    }
}
