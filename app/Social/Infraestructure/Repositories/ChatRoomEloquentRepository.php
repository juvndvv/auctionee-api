<?php

namespace App\Social\Infraestructure\Repositories;

use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Infraestructure\Repositories\Models\EloquentChatRoomModel;

class ChatRoomEloquentRepository implements ChatRoomRepositoryPort
{

    public function findByUuid(string $uuid): ChatRoom
    {
        $chatRoomDb = EloquentChatRoomModel::query()->where("uuid", $uuid)->firstOrFail();
        return ChatRoom::fromPrimitives($chatRoomDb->toArray());
    }

    public function create(ChatRoom $chatRoom): void
    {
        EloquentChatRoomModel::query()->create($chatRoom->toPrimitives());
    }

    public function existsByLeftAndRight(string $leftUuid, string $rightUuid): bool
    {
        return EloquentChatRoomModel::query()
            ->where("left_uuid", $leftUuid)
            ->where("right_uuid", $rightUuid)
            ->exists();
    }
}
