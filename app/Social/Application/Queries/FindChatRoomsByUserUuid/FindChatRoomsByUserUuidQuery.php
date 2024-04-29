<?php

namespace App\Social\Application\Queries\FindChatRoomsByUserUuid;

use App\Shared\Application\Queries\Query;

final class FindChatRoomsByUserUuidQuery extends Query
{
    public function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
