<?php

namespace App\Social\Application\FindMessagesByChatRoomUuid;

use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;

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
