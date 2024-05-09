<?php

namespace App\Social\Domain\Services;

use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

class ChatRoomService
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository
    )
    {}

    public function __invoke(string $leftUuid, string $rightUuid): ChatRoom
    {
        $room = ChatRoom::create($leftUuid, $rightUuid);
        $this->chatRoomRepository->create($room->toPrimitives());
        return $room;
    }
}
