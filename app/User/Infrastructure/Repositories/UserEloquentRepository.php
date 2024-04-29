<?php

namespace App\User\Infrastructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Repositories\BaseRepository;
use App\User\Domain\Models\User;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Support\Collection;

final class UserEloquentRepository extends BaseRepository implements UserRepositoryPort
{
    private const ENTITY_NAME = 'user';

    public function __construct()
    {
        $this->setBuilderFromModel(EloquentUserModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Collection<User>
     * @throws NoContentException
     */
    public function findAll(int $offset = 0, int $limit = 20): Collection
    {
        $users = parent::findAll($offset, $limit);
        return $users->map(fn ($user) => User::fromPrimitives($user->toArray()));
    }

    public function findByUuid(string $uuid): User
    {
        $userDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return User::fromPrimitives($userDb->toArray());
    }

    public function findByUsername(string $username): User
    {
        $userDb = parent::findByFieldValue(User::SERIALIZED_USERNAME, $username)['0'];
        return User::fromPrimitives($userDb->toArray());
    }

    public function updateName(string $uuid, string $name): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_NAME, $name);
    }

    public function updateUsername(string $uuid, string $username): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_USERNAME, $username);
    }

    public function updateEmail(string $uuid, string $email): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_EMAIL, $email);
    }

    public function updatePassword(string $uuid, string $password): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_PASSWORD, $password);
    }

    /**
     * @throws NotFoundException
     */
    public function updateAvatar(string $uuid, string $avatar): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_AVATAR, $avatar);
    }

    /**
     * @throws NotFoundException
     */
    public function block(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_ROLE, User::BLOCKED_ROLE);
    }

    /**
     * @throws NotFoundException
     */
    public function unblock(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_ROLE, User::USER_ROLE);
    }
}
