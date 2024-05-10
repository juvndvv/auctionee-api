<?php

namespace App\Social\Application\Queries\FindChatRoomsByUserUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Domain\Resources\ChatRoomResource;
use App\Social\Domain\Resources\MessageResource;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Support\Collection;

final class FindChatRoomsByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository,
        private readonly ChatMessagesRepositoryPort $chatMessagesRepository,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @returns Collection<ChatRoomResource>
     * @throws NoContentException
     */
    public function __invoke(FindChatRoomsByUserUuidQuery $query): Collection
    {
        $uuid = $query->uuid();
        $chatRooms = $this->chatRoomRepository->findByUserUuid($uuid);

        return $chatRooms->map(function (ChatRoom $chatRoom) use ($uuid) {
            $otherUserUuid = $chatRoom->left() !== $uuid ? $chatRoom->left() : $chatRoom->right();
            $otherUser = $this->userRepository->findByUuid($otherUserUuid);

            $chatRoomUuid = $chatRoom->uuid();
            $name = $otherUser->name();
            $avatar = $otherUser->avatar();
            $lastMessage = $this->chatMessagesRepository->findLastMessageByChatRoomUuid($chatRoomUuid);

            if (!is_null($lastMessage)) {
                $content = $lastMessage->content;
                if ($lastMessage->sender_uuid === $uuid)
                    $content = "Tu: {$content}";

                $lastMessage = MessageResource::create($lastMessage->uuid, $content, $lastMessage->created_at, $lastMessage->sender_uuid);
            }

            return ChatRoomResource::create($chatRoomUuid, $name, $avatar, $lastMessage);
        });
    }
}
