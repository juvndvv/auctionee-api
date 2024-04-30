<?php

namespace App\Social\Domain\Ports;

use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Resources\MessageResource;
use Illuminate\Support\Collection;

interface ChatMessagesRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param string $chatRoomUuid
     * @return Collection<MessageResource>
     */
    public function findAllByChatRoomUuid(string $chatRoomUuid): Collection;

    public function findByUuid(string $uuid): Message;
    public function exists(string $uuid): bool;
}
