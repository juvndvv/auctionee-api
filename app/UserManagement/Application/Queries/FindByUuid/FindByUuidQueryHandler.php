<?php

namespace App\UserManagement\Application\Queries\FindByUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Domain\Resources\UserDetailsResource;

class FindByUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(FindByUuidQuery $query): array
    {
        $uuid = $query->uuid();
        $user = $this->userRepository->findByUuid($uuid);
        return UserDetailsResource::fromArray($user->toArray());
    }
}
