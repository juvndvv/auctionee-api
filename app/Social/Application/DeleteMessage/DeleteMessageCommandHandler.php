<?php

namespace App\Social\Application\DeleteMessage;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Events\EventBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteMessageCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository,
        private readonly ChatMessagesRepositoryPort $chatMessagesRepository,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(DeleteMessageCommand $command): void
    {
        try {
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

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("No se encontro el mensaje");
        }

    }
}
