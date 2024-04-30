<?php

namespace App\Social\Application\Queries\FindMessagesByChatRoomUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Domain\Resources\MessageResource;
use Illuminate\Support\Collection;

final class FindMessagesByChatRoomUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ChatMessagesRepositoryPort $chatMessageRepository,
        private readonly ChatRoomRepositoryPort  $chatRoomRepository
    )
    {}

    /**
     * @param FindMessagesByChatRoomUuidQuery $query
     * @return Collection<MessageResource>
     * @throws NotFoundException
     */
    public function __invoke(FindMessagesByChatRoomUuidQuery $query): Collection
    {
        $uuid = $query->uuid();

        if (!$this->chatRoomRepository->exists($uuid)) {
            throw new NotFoundException("No existe el chat");
        }

        return $this->chatMessageRepository->findAllByChatRoomUuid($uuid);
    }
}
