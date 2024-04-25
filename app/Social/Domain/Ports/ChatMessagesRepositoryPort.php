<?php

namespace App\Social\Domain\Ports;

use App\Social\Domain\Models\Message;
use Illuminate\Support\Collection;

interface ChatMessagesRepositoryPort
{
    /**
     * @param array $data
     * @return void
     */
    public function save(array $data): void;

    /**
     * @param string $uuid
     * @return void
     */
    public function delete(string $uuid): void;

    /**
     * @param string $chatRoomUuid
     * @return Collection<Message>
     */
    public function findAllByChatRoomUuid(string $chatRoomUuid): Collection;

    public function findByUuid(string $uuid): Message;
}
