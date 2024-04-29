<?php

namespace App\Review\Application\Query\FindUserAverage;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Domain\Projections\UserAverageProjection;
use App\Shared\Application\Commands\QueryHandler;

final class FindUserAverageQueryHandler extends QueryHandler
{
    public function __construct(private readonly ReviewRepositoryPort $reviewRepository)
    {}

    public function __invoke(FindUserAverageQuery $query): UserAverageProjection
    {
        $userUuid = $query->userUuid();
        return $this->reviewRepository->findUserAverageRating($userUuid);
    }
}
