<?php

namespace App\User\Application\Queries\FindAll;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Domain\Resources\UserSmallResource;
use Illuminate\Support\Collection;

final class FindAllUserQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllUserQuery $query): Collection
    {
        $users = $this->userRepository->findAll();
        return $users->map(fn ($user) => UserSmallResource::create($user));
    }
}