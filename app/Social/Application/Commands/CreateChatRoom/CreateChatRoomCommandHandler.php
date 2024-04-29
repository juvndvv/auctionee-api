<?php declare(strict_types=1);

namespace App\Social\Application\Commands\CreateChatRoom;

use App\Shared\Application\Commands\CommandHandler;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

final class CreateChatRoomCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository
    )
    {}

    public function __invoke(CreateChatRoomCommand $command): void
    {
        $leftUuid = $command->leftUuid();
        $rightUuid = $command->rightUuid();

        $chatRoom = ChatRoom::create($leftUuid, $rightUuid);

        $this->chatRoomRepository->create($chatRoom->toPrimitives());
    }
}
