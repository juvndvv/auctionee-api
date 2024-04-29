<?php

namespace App\Social\Application\Queries\FindMessagesByChatRoomUuid;


use App\Shared\Application\Queries\Query;

class FindMessagesByChatRoomUuidQuery extends Query
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid()
    {
        return $this->uuid;
    }
}
