<?php

namespace App\Social\Application\Commands\SendMessage;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

class SendMessageCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatMessagesRepositoryPort $chatMessageRepository,
        private readonly ChatRoomRepositoryPort $chatRoomRepositoryPort,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(SendMessageCommand  $command): void
    {
        $chatRoomUuid = $command->chatRoomUuid();
        $senderUuid = $command->senderuuid();
        $content = $command->content();

        // Query data
        $chatRoom = $this->chatRoomRepositoryPort->findByUuid($chatRoomUuid);

        // Use case
        $chatRoom->addMessage($senderUuid, $content);

        // Persistence
        $message = $chatRoom->lastMessagePrimitives();
        $this->chatMessageRepository->save($message);

        // Publish events
        $this->eventBus->dispatch(...$chatRoom->pullDomainEvents());
    }
}
