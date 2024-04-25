<?php

namespace App\UserManagement\Application\FindByUuid;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;
use App\UserManagement\Application\Resources\UserDetailsResource;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class FindByUuidQueryHandler extends QueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUuidQuery $query): array
    {
        $uuid = $query->uuid();

        $user = $this->userRepository->findByUuid($uuid);

        if (is_null($user)) {
            throw new NotFoundException("Usuario con uuid $uuid no encontrado");
        }

        return UserDetailsResource::fromArray($user->toArray());
    }
}
