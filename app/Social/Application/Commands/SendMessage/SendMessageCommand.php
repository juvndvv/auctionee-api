<?php

namespace App\Social\Application\Commands\SendMessage;

use App\Shared\Application\Commands\Command;

final class SendMessageCommand extends Command
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
