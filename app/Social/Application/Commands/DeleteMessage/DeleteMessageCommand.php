<?php

namespace App\Social\Application\Commands\DeleteMessage;

use App\Shared\Application\Commands\Command;

final class DeleteMessageCommand extends Command
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
}
