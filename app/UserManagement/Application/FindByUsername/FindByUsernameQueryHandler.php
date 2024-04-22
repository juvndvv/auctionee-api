<?php

namespace App\UserManagement\Application\FindByUsername;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Application\Resources\UserDetailsResource;
use App\UserManagement\Application\Resources\UserSmallResource;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class FindByUsernameQueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUsernameQuery $query): array
    {
        $username = $query->username();

        $user = $this->userRepository->findByUsername($username);

        if (is_null($user)) {
            throw new NotFoundException("Usuario $username no encontrado");
        }

        return UserSmallResource::fromArray($user->toArray());
    }
}
