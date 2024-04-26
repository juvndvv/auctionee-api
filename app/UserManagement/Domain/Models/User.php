<?php

namespace App\UserManagement\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\UserManagement\Domain\Events\UserBlockedEvent;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Events\UserDeletedEvent;
use App\UserManagement\Domain\Events\UserUnblockedEvent;
use App\UserManagement\Domain\Events\UserUpdatedEvent;
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
    public const SERIALIZED_UUID = 'uuid';
    public const SERIALIZED_NAME = 'name';
    public const SERIALIZED_USERNAME = 'username';
    public const SERIALIZED_EMAIL = 'email';
    public const SERIALIZED_PASSWORD = 'password';
    public const SERIALIZED_AVATAR = 'avatar';
    public const SERIALIZED_BIRTH = 'birth';
    public const SERIALIZED_ROLE = 'role';

    public const USER_ROLE = 0;
    public const ADMIN_ROLE = 1;
    public const BLOCKED_ROLE = 2;

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

        $user->record(new UserCreatedEvent($user->toPrimitives(), now()->toString()));

        return $user;
    }

    public static function fromPrimitives(array $data): User
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_NAME],
            $data[self::SERIALIZED_USERNAME],
            $data[self::SERIALIZED_EMAIL],
            $data[self::SERIALIZED_PASSWORD],
            $data[self::SERIALIZED_AVATAR],
            $data[self::SERIALIZED_BIRTH],
            $data[self::SERIALIZED_ROLE]
        );
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->id->value(),
            self::SERIALIZED_NAME => $this->name->value(),
            self::SERIALIZED_USERNAME => $this->username->value(),
            self::SERIALIZED_EMAIL => $this->email->value(),
            self::SERIALIZED_PASSWORD => $this->password->value(),
            self::SERIALIZED_AVATAR => $this->avatar->value(),
            self::SERIALIZED_BIRTH => $this->birth->value(),
            self::SERIALIZED_ROLE => $this->role->value(),
        ];
    }

    public function updateAvatar(string $new): void
    {
        $old = $this->avatar->value();
        $this->avatar = new UserAvatar($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'avatar',
                'old' => $old,
                'new' => $new
        ], now()->toString()));
    }

    public function updateName(string $new): void
    {
        $old = $this->name->value();
        $this->name = new UserName($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'name',
                'old' => $old,
                'new' => $new
            ], now()->toString()));
    }

    public function updateUsername(string $new): void
    {
        $old = $this->username->value();
        $this->username = new UserUsername($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'username',
                'old' => $old,
                'new' => $new
            ], now()->toString()));
    }

    public function updateEmail(string $new): void
    {
        $old = $this->email->value();
        $this->email = new UserEmail($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'email',
                'old' => $old,
                'new' => $new
            ], now()->toString()));
    }

    public function updatePassword(string $new): void
    {
        $this->password = new UserPassword($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'password',
            ], now()->toString()));
    }

    public function delete(): void
    {
        $this->record(new UserDeletedEvent(self::toPrimitives(), now()->toString()));
    }

    public function block(): void
    {
        $this->role = new UserRole(2);
        $this->record(new UserBlockedEvent($this->toPrimitives(), now()->toString()));
    }

    public function unblock(): void
    {
        $this->role = new UserRole(0);
        $this->record(new UserUnblockedEvent($this->toPrimitives(), now()->toString()));
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
