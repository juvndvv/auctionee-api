<?php

namespace App\User\Application\Queries\FindAll;

use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Domain\Projections\UserSmallProjection;
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
        $offset = $query->offset();
        $limit = $query->limit();

        $users = $this->userRepository->findAll($offset, $limit);
        return $users->map(fn ($user) => UserSmallProjection::create($user));
    }
}
