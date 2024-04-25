<?php

namespace App\Social\Domain\Ports;

use App\Social\Domain\Models\ChatRoom;
use Illuminate\Support\Collection;

interface ChatRoomRepositoryPort
{
    public function findByUuid(string $uuid): ChatRoom;
    public function create(ChatRoom $chatRoom): void;
    public function existsByLeftAndRight(string $leftUuid, string $rightUuid): bool;

    /**
     * @param string $uuid
     * @return Collection<ChatRoom>
     */
    public function findByUserUuid(string $uuid): Collection;
}
