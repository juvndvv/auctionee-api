<?php

namespace App\Review\Application\FindUserReviews;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;

class FindUserReviewsQueryHandler
{
    public function __construct(private ReviewRepositoryPort $reviewRepository)
    {}

    public function __invoke(FindUserReviewsQuery $query)
    {
        $reviewedUuid = $query->reviewedUuid();
        return $this->reviewRepository->findByUserUuid($reviewedUuid)->toArray();
    }
}
