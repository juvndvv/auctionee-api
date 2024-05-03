<?php

namespace App\Social\Application\Queries\FindMessagesByChatRoomUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
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
     * @return Collection
     * @throws NotFoundException, NoContentException
     * @throws NoContentException
     */
    public function __invoke(FindMessagesByChatRoomUuidQuery $query): Collection
    {
        $uuid = $query->uuid();
        $token = $query->token();

        if (!$this->chatRoomRepository->exists($uuid)) {
            throw new NotFoundException("No existe el chat");
        }

        $messages = $this->chatMessageRepository->findAllByChatRoomUuid($uuid, $token);

        // Genera el nuevo token
        $token = base64_encode($messages->last()->date);

        return collect(['messages' => $messages, 'token' => $token]);
    }
}
