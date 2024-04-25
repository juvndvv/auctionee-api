<?php

namespace App\UserManagement\Application\Queries\FindAll;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Domain\Resources\UserDetailsResource;

class FindAllUserQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllUserQuery $query): array
    {
        $users = $this->userRepository->findAll();

        $userResourceArr = [];

        foreach ($users as $user) {
            $userResourceArr[] = UserDetailsResource::fromArray($user->toArray());
        }

        return $userResourceArr;
    }
}
