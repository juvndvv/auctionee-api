<?php

namespace App\User\Application\Queries\FindByUsername;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Domain\Resources\UserSmallResource;

final class FindByUsernameQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUsernameQuery $query): UserSmallResource
    {
        $username = $query->username();
        $user = $this->userRepository->findByUsername($username);
        return UserSmallResource::create($user);
    }
}
