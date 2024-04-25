<?php

namespace App\Social\Domain\Ports;

use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Support\Collection;

interface FriendshipRepositoryPort extends BaseRepositoryPort
{
    /**
     * Obtiene la lista de amigos para el usuario identificado con <i>uuid</i>
     *
     * @param string $uuid
     * @return Collection
     */
    public function findFriendsByUserUuid(string $uuid): Collection;
}
