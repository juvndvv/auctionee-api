<?php

namespace App\Social\Application\FindChatRoomsByUserUuid;

use App\Shared\Domain\Bus\Command\Command;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

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
