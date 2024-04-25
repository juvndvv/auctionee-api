<?php

namespace App\Social\Application\FindMessagesByChatRoomUuid;

use App\Shared\Infraestructure\Bus\Query\Query;

class FindMessagesByChatRoomUuidQuery extends Query
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid()
    {
        return $this->uuid;
    }
}
