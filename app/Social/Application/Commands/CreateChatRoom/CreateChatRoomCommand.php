<?php

namespace App\Social\Application\Commands\CreateChatRoom;

use App\Shared\Application\Commands\Command;

class CreateChatRoomCommand extends Command
{
    public function __construct(
        private readonly string $leftUuid,
        private readonly string $rightUuid,
    )
    {}

    public function leftUuid(): string
    {
        return $this->leftUuid;
    }

    public function rightUuid(): string
    {
        return $this->rightUuid;
    }
}
