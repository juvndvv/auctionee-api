<?php

namespace App\Social\Domain\Services;

use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;

class MessageSenderService
{
    public function __construct(
        private ChatMessagesRepositoryPort $chatMessagesRepository,
    )
    {}

    public function __invoke(ChatRoom $chatRoom, string $senderUuid, string $content): void
    {
        $message = Message::create($senderUuid, $content);
        $chatRoom->addMessage($message);
        $this->chatMessagesRepository->save($message);
    }
}
