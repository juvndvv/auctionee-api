<?php

namespace App\Social\Application\FindMessagesByChatRoomUuid;

use App\Shared\Domain\Bus\Query\Query;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

class FindMessagesByChatRoomUuidQuery extends Query
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid()
    {
        return $this->uuid;
    }
}
