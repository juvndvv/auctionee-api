<?php

namespace App\Social\Domain\Ports;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use App\Social\Domain\Models\ChatRoom;
use Illuminate\Support\Collection;

interface ChatRoomRepositoryPort extends BaseRepositoryPort
{
    /**
     * Busca el chat por <i>UUID</i>
     *
     * @param string $uuid
     * @return ChatRoom
     */
    public function findByUuid(string $uuid): ChatRoom;

    /**
     * @param string $uuid
     * @return bool
     */
    public function exists(string $uuid): bool;

    /**
     * @param string $leftUuid
     * @param string $rightUuid
     * @return bool
     */
    public function existsByLeftAndRight(string $leftUuid, string $rightUuid): bool;

    /**
     * @param string $uuid
     * @return Collection<ChatRoom>
     * @throws NoContentException
     */
    public function findByUserUuid(string $uuid): Collection;
}
