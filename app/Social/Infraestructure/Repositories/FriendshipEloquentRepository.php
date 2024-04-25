<?php

namespace App\Social\Infraestructure\Repositories;

use App\Social\Domain\Models\Friendship;
use App\Social\Domain\Ports\FriendshipRepositoryPort;
use App\Social\Infraestructure\Repositories\Models\EloquentFriendshipModel;
use Illuminate\Support\Collection;

class FriendshipEloquentRepository implements FriendshipRepositoryPort
{

    /**
     * @param string $uuid
     * @return Collection
     */
    public function findFriendsByUserUuid(string $uuid): Collection
    {
        $friends = EloquentFriendshipModel::query()
            ->select('users.name')
            ->where(Friendship::SERIALIZED_LEFT_UUID, $uuid)
            ->orWhere(Friendship::SERIALIZED_RIGHT_UUID, $uuid)
            ->join('users', 'users.id', '=', 'friendships.left_uuid')
            ->join('users', 'users.id', '=', 'friendships.right_uuid')
            ->get()
            ->collect();

        return $friends;
    }
}
