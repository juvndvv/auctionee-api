<?php

namespace App\Social\Application\DeleteMessage;

use App\Shared\Infraestructure\Bus\Command\Command;

class DeleteMessageCommand extends Command
{
    public function __construct(
        private readonly string $chatRoomUuid,
        private readonly string $messageUuid,
    )
    {}

    public function chatRoomUuid(): string
    {
        return $this->chatRoomUuid;
    }

    public function messageUuid(): string
    {
        return $this->messageUuid;
    }

    public function ownerUuid(): string
    {
        return $this->ownerUuid;
    }
}
