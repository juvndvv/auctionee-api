<?php

namespace App\Social\Application\SendMessage;

use App\Shared\Domain\Bus\Command\Command;

class SendMessageCommand extends Command
{
    public function __construct(
        private readonly string $chatRoomUuid,
        private readonly string $senderUuid,
        private readonly string $content
    )
    {}

    public function chatRoomUuid(): string
    {
        return $this->chatRoomUuid;
    }

    public function senderUuid(): string
    {
        return $this->senderUuid;
    }

    public function content(): string
    {
        return $this->content;
    }
}
