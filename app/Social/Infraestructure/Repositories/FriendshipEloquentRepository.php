<?php

namespace App\Social\Infraestructure\Repositories;

use App\Shared\Infraestructure\Repositories\BaseRepository;
use App\Social\Domain\Ports\FriendshipRepositoryPort;
use App\Social\Infraestructure\Repositories\Models\EloquentFriendshipModel;
use Illuminate\Support\Collection;

class FriendshipEloquentRepository extends BaseRepository implements FriendshipRepositoryPort
{
    public const ENTITY_NAME = 'Friendship';

    public function __construct()
    {
        self::setBuilderFromModel(EloquentFriendshipModel::query()->getModel());
        self::setEntityName(self::ENTITY_NAME);
    }

    public function findFriendsByUserUuid(string $uuid): Collection
    {
        $firstCollection = self::findLeftUuidByRightUuid($uuid);
        $secondCollection = self::findRightUuidByLeftUuid($uuid);

        return $firstCollection->merge($secondCollection);
    }

    /**
     * Busca el uuid del amigo <i>left</i>
     *
     * @param string $rightUuid
     * @return Collection
     */
    private function findLeftUuidByRightUuid(string $rightUuid): Collection
    {
        return self::findByFieldValue('right_uuid', $rightUuid);
    }

    /**
     * Busca el uuid del amigo <i>right</i>
     *
     * @param string $leftUuid
     * @return Collection
     */
    private function findRightUuidByLeftUuid(string $leftUuid): Collection
    {
        return self::findByFieldValue('left_uuid', $leftUuid);
    }
}
