<?php

namespace App\Social\Application\Queries\FindMessagesByChatRoomUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use Illuminate\Support\Collection;

class FindMessagesByChatRoomUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ChatMessagesRepositoryPort $chatMessageRepository
    )
    {}

    public function __invoke(FindMessagesByChatRoomUuidQuery $query): Collection
    {
        $uuid = $query->uuid();
        return $this->chatMessageRepository->findAllByChatRoomUuid($uuid);
    }
}
