<?php

namespace App\Social\Infrastructure\Repositories;

use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Infrastructure\Repositories\Models\EloquentMessageModel;
use Illuminate\Support\Collection;

class ChatMessagesEloquentRepository implements ChatMessagesRepositoryPort
{

    public function save(array $data): void
    {
        EloquentMessageModel::query()->create($data);
    }

    public function findAllByChatRoomUuid(string $chatRoomUuid): Collection
    {
        return EloquentMessageModel::query()
            ->where('chat_room_uuid', $chatRoomUuid)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function delete(string $uuid): void
    {
        EloquentMessageModel::query()->where('uuid', $uuid)->delete();
    }

    public function findByUuid(string $uuid): Message
    {
        $messageDb = EloquentMessageModel::query()
            ->where('uuid', $uuid)
            ->firstOrFail()
            ->toArray();

        return Message::fromPrimitives($messageDb);
    }
}
