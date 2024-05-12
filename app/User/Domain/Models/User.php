<?php

namespace App\User\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Events\UserBlockedEvent;
use App\User\Domain\Events\UserCreatedEvent;
use App\User\Domain\Events\UserDeletedEvent;
use App\User\Domain\Events\UserUnblockedEvent;
use App\User\Domain\Events\UserUpdatedEvent;
use App\User\Domain\Models\ValueObjects\UserBirth;
use App\User\Domain\Models\ValueObjects\UserEmail;
use App\User\Domain\Models\ValueObjects\UserUuid;
use App\User\Domain\Models\ValueObjects\UserAvatar;
use App\User\Domain\Models\ValueObjects\UserName;
use App\User\Domain\Models\ValueObjects\UserPassword;
use App\User\Domain\Models\ValueObjects\UserRole;
use App\User\Domain\Models\ValueObjects\UserUsername;

final class User extends AggregateRoot
{
    public const string UUID = 'uuid';
    public const string NAME = 'name';
    public const string USERNAME = 'username';
    public const string EMAIL = 'email';
    public const string PASSWORD = 'password';
    public const string AVATAR = 'avatar';
    public const string BIRTH = 'birth';
    public const string ROLE = 'role';

    public const int USER_ROLE = 0;
    public const int ADMIN_ROLE = 1;
    public const int BLOCKED_ROLE = 2;

    private UserUuid $id;
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
        $this->id = new UserUuid($uuid);
        $this->name = new UserName($name);
        $this->username = new UserUsername($username);
        $this->email = new UserEmail($email);
        $this->password = new UserPassword($password);
        $this->avatar = new UserAvatar($avatar);
        $this->birth = new UserBirth($birth);
        $this->role = new UserRole($role);
    }

    public static function create($name, $username, $email, $password, $avatar, $birth, $role): User
    {
        $generatedId = UserUuid::random();

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
            $data[self::UUID],
            $data[self::NAME],
            $data[self::USERNAME],
            $data[self::EMAIL],
            $data[self::PASSWORD],
            $data[self::AVATAR],
            $data[self::BIRTH],
            $data[self::ROLE]
        );
    }

    public function toPrimitives(): array
    {
        return [
            self::UUID => $this->id->value(),
            self::NAME => $this->name->value(),
            self::USERNAME => $this->username->value(),
            self::EMAIL => $this->email->value(),
            self::PASSWORD => $this->password->value(),
            self::AVATAR => $this->avatar->value(),
            self::BIRTH => $this->birth->value(),
            self::ROLE => $this->role->value(),
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
                'new' => $new,
                'user' => $this->toPrimitives()
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
                'new' => $new,
                'user' => $this->toPrimitives()
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
                'new' => $new,
                'user' => $this->toPrimitives()
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
                'new' => $new,
                'user' => $this->toPrimitives()
            ], now()->toString()));
    }

    public function updatePassword(string $new): void
    {
        $this->password = new UserPassword($new);
        $this->record(new UserUpdatedEvent(
            [
                'field' =>'password',
                'user' => $this->toPrimitives()
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

    public function birth(): string
    {
        return $this->birth->value();
    }

    public function avatar(): string
    {
        return $this->avatar->value();
    }

    public function role(): string
    {
        return match ($this->role->value()) {
            "1" => "ADMIN",
            "2" => "BLOCKED",
            default => "USER",
        };
    }
}
