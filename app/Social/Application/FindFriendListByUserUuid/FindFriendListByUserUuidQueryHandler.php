<?php

namespace App\Social\Application\FindFriendListByUserUuid;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;
use App\Social\Domain\Ports\FriendshipRepositoryPort;

class FindFriendListByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly FriendshipRepositoryPort $friendshipRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindFriendListByUserUuidQuery $query)
    {
        $userUuid = $query->userUuid();

        $resources = $this->friendshipRepository->findFriendsByUserUuid($userUuid);

        if ($resources->count() === 0) {
            throw new NoContentException("No hay amigos");
        }

        return $resources;
    }
}
