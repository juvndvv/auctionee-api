<?php

namespace App\Social\Domain\Ports;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use App\Social\Domain\Models\Message;
use App\Social\Domain\Resources\MessageResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ChatMessagesRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param string $chatRoomUuid
     * @param string $fromDate
     * @return Collection<MessageResource>
     * @throws NoContentException
     */
    public function findAllByChatRoomUuid(string $chatRoomUuid, string $fromDate): Collection;
    public function findByUuid(string $uuid): Message;
    public function exists(string $uuid): bool;
    public function delete(string $uuid): void;
    public function findLastMessageByChatRoomUuid(string $chatRoomUuid): Model | null;
}
