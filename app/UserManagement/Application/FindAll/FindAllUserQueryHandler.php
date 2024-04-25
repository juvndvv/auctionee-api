<?php

namespace App\UserManagement\Application\FindAll;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;
use App\UserManagement\Application\Resources\UserDetailsResource;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class FindAllUserQueryHandler extends QueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllUserQuery $query): array
    {
        $users = $this->userRepository->findAll();

        if ($users->count() === 0) {
            throw new NoContentException("No existen usuarios");
        }

        $userResourceArr = [];

        foreach ($users as $user) {
            $userResourceArr[] = UserDetailsResource::fromArray($user->toArray());
        }

        return $userResourceArr;
    }
}
