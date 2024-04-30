<?php declare(strict_types=1);

namespace App\Social\Application\Commands\CreateChatRoom;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\BadRequestException;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

final class CreateChatRoomCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository
    )
    {}

    /**
     * @throws BadRequestException
     */
    public function __invoke(CreateChatRoomCommand $command): void
    {
        $leftUuid = $command->leftUuid();
        $rightUuid = $command->rightUuid();

        if ($this->chatRoomRepository->existsByLeftAndRight($leftUuid, $rightUuid)) {
            throw new BadRequestException("La sala ya existe");
        }

        $chatRoom = ChatRoom::create($leftUuid, $rightUuid);

        $this->chatRoomRepository->create($chatRoom->toPrimitives());
    }
}
