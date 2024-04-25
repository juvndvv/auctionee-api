<?php

namespace App\Social\Domain\Ports;

use Illuminate\Support\Collection;

interface FriendshipRepositoryPort
{
    public function findFriendsByUserUuid(string $uuid): Collection;
}
