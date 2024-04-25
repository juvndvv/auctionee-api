<?php

namespace App\Social\Infraestructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Infraestructure\Repositories\Models\EloquentChatRoomModel;
use Illuminate\Support\Collection;

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

    public function findByUserUuid(string $uuid): Collection
    {
        $chatRoomsDb = EloquentChatRoomModel::query()
            ->where("left_uuid", $uuid)
            ->orWhere("right_uuid", $uuid)
            ->get()
        ->collect();

        if ($chatRoomsDb->count() === 0) {
            throw new NoContentException("No hay chats disponibles");
        }

        return $chatRoomsDb->map(
            function (EloquentChatRoomModel $chatRoom) {
                return ChatRoom::fromPrimitives($chatRoom->toArray());
            }
        );
    }
}
