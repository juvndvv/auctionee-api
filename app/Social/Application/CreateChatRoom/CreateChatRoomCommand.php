<?php

namespace App\Social\Application\CreateChatRoom;

use App\Shared\Domain\Bus\Command\Command;

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
