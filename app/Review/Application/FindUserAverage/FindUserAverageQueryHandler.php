<?php

namespace App\Review\Application\FindUserAverage;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;

class FindUserAverageQueryHandler extends QueryHandler
{
    public function __construct(private readonly ReviewRepositoryPort $reviewRepository)
    {}

    public function __invoke(FindUserAverageQuery $query)
    {
        $userUuid = $query->userUuid();
        return $this->reviewRepository->findUserAverageRating($userUuid);
    }
}
