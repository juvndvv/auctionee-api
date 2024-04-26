<?php

namespace App\Social\Application\FindMessagesByChatRoomUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;

class FindMessagesByChatRoomUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ChatMessagesRepositoryPort $chatMessageRepository
    )
    {}

    public function __invoke(FindMessagesByChatRoomUuidQuery $query)
    {
        $uuid = $query->uuid();
        return $this->chatMessageRepository->findAllByChatRoomUuid($uuid);
    }
}
