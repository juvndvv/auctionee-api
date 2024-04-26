<?php

namespace App\User\Application\Queries\FindByUuid;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Domain\Resources\UserDetailsResource;

final class FindByUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUuidQuery $query): array
    {
        $uuid = $query->uuid();
        return $this->userRepository->findByUuid($uuid)->toPrimitives();
    }
}
