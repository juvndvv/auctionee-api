<?php

namespace App\UserManagement\Application\FindAll;

use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\Collection;

class FindAllUserQueryHandler extends QueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllUserQuery $query): Collection
    {
        $users = $this->userRepository->findAll();

        if ($users->count() === 0) {
            throw new NoContentException("No existen usuarios");
        }

        return $users;
    }
}
