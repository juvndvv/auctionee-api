<?php

namespace App\Social\Application\Queries\FindChatRoomsByUserUuid;

use App\Shared\Application\Commands\CommandHandler;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

class FindChatRoomsByUserUuidQueryHandler extends CommandHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository
    )
    {}

    public function __invoke(FindChatRoomsByUserUuidQuery $query)
    {
        $uuid = $query->uuid();
        $chatRooms = $this->chatRoomRepository->findByUserUuid($uuid);

        return $chatRooms->map(
            function (ChatRoom $chatRoom) {
                return $chatRoom->toPrimitives();
            }
        );
    }
}
