<?php

namespace App\Social\Infrastructure\Repositories;

use App\Shared\Infrastructure\Repositories\BaseRepository;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Resources\MessageResource;
use App\Social\Infrastructure\Repositories\Models\EloquentMessageModel;
use Illuminate\Support\Collection;

class ChatMessagesEloquentRepository extends BaseRepository implements ChatMessagesRepositoryPort
{
    public const string ENTITY_NAME = "chat_message";

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentMessageModel::query()->getModel());
    }

    public function findAllByChatRoomUuid(string $chatRoomUuid): Collection
    {
        $messagesDb = EloquentMessageModel::query()
            ->select(['uuid', 'content', 'created_at'])
            ->where('chat_room_uuid', $chatRoomUuid)
            ->orderBy('created_at', 'desc')
            ->get();

        return $messagesDb->map(fn ($message) => MessageResource::create(
            $message->uuid,
            $message->content,
            $message->created_at
        ));
    }

    public function findByUuid(string $uuid): Message
    {
        $messageDb = EloquentMessageModel::query()
            ->where('uuid', $uuid)
            ->firstOrFail()
            ->toArray();

        return Message::fromPrimitives($messageDb);
    }

    public function exists(string $uuid): bool
    {
        return EloquentMessageModel::query()
            ->where('uuid', $uuid)
            ->exists();
    }
}
