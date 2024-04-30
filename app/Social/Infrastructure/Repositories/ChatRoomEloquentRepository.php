<?php

namespace App\Social\Infrastructure\Repositories;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Infrastructure\Repositories\Models\EloquentChatRoomModel;
use Illuminate\Support\Collection;

final class ChatRoomEloquentRepository extends BaseRepository implements ChatRoomRepositoryPort
{
    public const string ENTITY_NAME = 'chat_room';

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentChatRoomModel::query()->getModel());
    }

    public function findByUuid(string $uuid): ChatRoom
    {
        $chatRoomDb = EloquentChatRoomModel::query()->where("uuid", $uuid)->firstOrFail();
        return ChatRoom::fromPrimitives($chatRoomDb->toArray());
    }

    public function existsByLeftAndRight(string $leftUuid, string $rightUuid): bool
    {
        $option1 = EloquentChatRoomModel::query()
            ->where("left_uuid", $leftUuid)
            ->where("right_uuid", $rightUuid)
            ->exists();

        $option2 = EloquentChatRoomModel::query()
            ->where("left_uuid", $rightUuid)
            ->where("right_uuid", $leftUuid)
            ->exists();

        return $option1 || $option2;
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

    public function exists(string $uuid): bool
    {
        return EloquentChatRoomModel::query()
            ->where("uuid", $uuid)
            ->exists();
    }
}
