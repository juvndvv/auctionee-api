<?php

namespace App\Social\Application\FindChatRoomsByUserUuid;

use App\Shared\Application\Commands\Command;

class FindChatRoomsByUserUuidQuery extends Command
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