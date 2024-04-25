<?php

namespace App\Social\Infraestructure\Repositories;

use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Infraestructure\Repositories\Models\EloquentMessageModel;
use Illuminate\Support\Collection;

class ChatMessagesEloquentRepository implements ChatMessagesRepositoryPort
{

    public function save(array $data): void
    {
        EloquentMessageModel::query()->create($data);
    }

    public function findAllByChatRoomUuid(string $chatRoomUuid): Collection
    {
        return EloquentMessageModel::query()->where('chat_room_uuid', $chatRoomUuid)->get();
    }
}
