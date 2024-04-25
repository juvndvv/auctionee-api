<?php

namespace App\UserManagement\Application\Queries\FindByUsername;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Domain\Resources\UserSmallResource;

class FindByUsernameQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUsernameQuery $query): array
    {
        $username = $query->username();
        $user = $this->userRepository->findByUsername($username);
        return UserSmallResource::fromArray($user->toArray());
    }
}
