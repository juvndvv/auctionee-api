<?php

namespace App\UserManagement\Infraestructure\Repositories;

use App\Shared\Infraestructure\Repositories\BaseRepository;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Model;

class UserEloquentRepository extends BaseRepository implements UserRepositoryPort
{
    private const ENTITY_NAME = 'user';

    public function __construct()
    {
        $this->setBuilderFromModel(EloquentUserModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    public function findByUuid(string $uuid): Model
    {
        return parent::findOneByPrimaryKeyOrFail($uuid);
    }

    public function findByUsername(string $username): Model
    {
        return parent::findByFieldValue(User::SERIALIZED_USERNAME, $username);
    }

    public function updateName(string $uuid, string $name): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_USERNAME, $name);
    }

    public function updateUsername(string $uuid, string $username): int
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

    public function updateAvatar(string $uuid, string $avatar): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_AVATAR, $avatar);
    }

    public function delete(string $uuid): void
    {
        parent::deleteByPrimaryKey($uuid);
    }

    public function block(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_ROLE, User::BLOCKED_ROLE);
    }

    public function unblock(string $uuid): void
    {
        parent::updateFieldByPrimaryKey($uuid, User::SERIALIZED_ROLE, User::USER_ROLE);
    }
}
