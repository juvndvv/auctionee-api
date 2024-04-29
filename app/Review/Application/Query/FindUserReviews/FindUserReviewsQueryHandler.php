<?php

namespace App\Review\Application\Query\FindUserReviews;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;

final class FindUserReviewsQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository
    )
    {}

    public function __invoke(FindUserReviewsQuery $query)
    {
        $reviewedUuid = $query->reviewedUuid();
        $reviews = $this->reviewRepository->findByReviewedUuid($reviewedUuid)->toArray();
        return $reviews;
    }
}
