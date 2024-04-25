<?php

namespace App\Social\Application\SendMessage;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Events\EventBus;
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
