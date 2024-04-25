<?php

namespace App\Social\Domain\Services;

use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;

class MessageSenderService
{
    public function __construct(
        private readonly ChatMessagesRepositoryPort $chatMessagesRepository
    )
    {}

    public function __invoke(string $senderUuid, string $content, ChatRoom $chatRoom): void
    {
        $message = Message::create($senderUuid, $content);
        $chatRoom->addMessage($message);
        $this->chatMessagesRepository->save($message);
    }
}
