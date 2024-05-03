<?php

namespace App\Social\Application\Commands\DeleteMessage;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class DeleteMessageCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository,
        private readonly ChatMessagesRepositoryPort $chatMessagesRepository,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(DeleteMessageCommand $command): void
    {
        $chatRoomUuid = $command->chatRoomUuid();
        $messageUuid = $command->messageUuid();

        // Query data
        $chatRoom = $this->chatRoomRepository->findByUuid($chatRoomUuid);
        $message = $this->chatMessagesRepository->findByUuid($messageUuid);

        // Use case
        $chatRoom->deleteMessage($message);

        // Persistence
        $this->chatMessagesRepository->delete($messageUuid);

        // Publish
        $this->eventBus->dispatch(...$chatRoom->pullDomainEvents());
    }
}
