<?php

namespace App\Social\Infrastructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Resources\MessageResource;
use App\Social\Infrastructure\Repositories\Models\EloquentMessageModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class EloquentChatMessagesRepository extends BaseRepository implements ChatMessagesRepositoryPort
{
    public const string ENTITY_NAME = "chat_message";

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentMessageModel::query()->getModel());
    }

    public function findAllByChatRoomUuid(string $chatRoomUuid, string $fromDate): Collection
    {
        if (empty($fromDate)) {
            $fromDate = now()->format('Y-m-d H:i:s');
        }

        $messagesDb = EloquentMessageModel::query()
            ->select(['uuid', 'content', 'created_at', 'sender_uuid'])
            ->where('chat_room_uuid', $chatRoomUuid)
            ->orderBy('created_at', 'desc')
            ->where('created_at', '<', $fromDate)
            ->limit(env('PAGINATION_LIMIT'))
            ->get();

        if ($messagesDb->count() ===  0) {
            throw new NoContentException();
        }

        return $messagesDb->map(fn ($message) => MessageResource::create(
            $message->uuid,
            $message->content,
            $message->created_at,
            $message->sender_uuid
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

    public function delete(string $uuid): void
    {
        EloquentMessageModel::query()
            ->where('uuid', $uuid)
            ->update(['content' => '!*! Mensaje eliminado']);
    }

    public function findLastMessageByChatRoomUuid(string $chatRoomUuid): Model | null
    {
        return EloquentMessageModel::query()
            ->where('chat_room_uuid', $chatRoomUuid)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();
    }
}
