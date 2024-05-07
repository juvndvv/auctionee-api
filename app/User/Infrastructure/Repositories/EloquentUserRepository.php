<?php

namespace App\User\Infrastructure\Repositories;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use App\User\Domain\Models\User;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Support\Collection;

final class EloquentUserRepository extends BaseRepository implements UserRepositoryPort
{
    private const string ENTITY_NAME = 'user';

    public function __construct()
    {
        $this->setModel(EloquentUserModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    public function findAll(int $offset, int $limit): Collection
    {
        $users = EloquentUserModel::query()->offset($offset)->limit($limit)->get();
        return $users->map(fn ($user) => User::fromPrimitives($user->toArray()));
    }

    public function findByUuid(string $uuid): User
    {
        $userDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return User::fromPrimitives($userDb->toArray());
    }

    public function findByUsername(string $username): User
    {
        $userDb = parent::findByFieldValue(User::USERNAME, $username)['0'];
        return User::fromPrimitives($userDb->toArray());
    }

    public function updateName(string $uuid, string $name): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::NAME, $name);
    }

    public function updateUsername(string $uuid, string $username): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::USERNAME, $username);
    }

    public function updateEmail(string $uuid, string $email): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::EMAIL, $email);
    }

    public function updatePassword(string $uuid, string $password): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::PASSWORD, $password);
    }

    public function updateAvatar(string $uuid, string $avatar): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::AVATAR, $avatar);
    }

    public function block(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::ROLE, User::BLOCKED_ROLE);
    }

    public function unblock(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::ROLE, User::USER_ROLE);
    }

    public function authenticate(string $email, string $password): string
    {
        $userDb = EloquentUserModel::query()
            ->where('email', $email)
            ->where('password', $password)
            ->first();

        if (!$userDb) {
            throw new BadRequestException("Email o contraseña incorrecta");
        }

        return $userDb->createToken('apiToken')->plainTextToken;
    }

    public function findByEmail(string $email): User
    {
        $userDb = parent::findByFieldValue(User::EMAIL, $email)['0'];
        return User::fromPrimitives($userDb->toArray());
    }
}
