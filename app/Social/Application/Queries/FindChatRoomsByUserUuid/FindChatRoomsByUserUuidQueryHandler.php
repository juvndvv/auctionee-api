<?php

namespace App\Social\Application\Queries\FindChatRoomsByUserUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Social\Domain\Models\ChatRoom;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Domain\Resources\ChatRoomResource;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Support\Collection;

final class FindChatRoomsByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ChatRoomRepositoryPort $chatRoomRepository,
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
            $username = $otherUser->username();
            $avatar = $otherUser->avatar();

            return ChatRoomResource::create($chatRoomUuid, $username, $avatar);
        });
    }
}
