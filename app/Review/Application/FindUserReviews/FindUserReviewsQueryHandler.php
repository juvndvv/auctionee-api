<?php

namespace App\Review\Application\FindUserReviews;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Domain\Exceptions\NoContentException;

class FindUserReviewsQueryHandler
{
    public function __construct(private ReviewRepositoryPort $reviewRepository)
    {}

    public function __invoke(FindUserReviewsQuery $query)
    {
        $reviewedUuid = $query->reviewedUuid();
        $reviews = $this->reviewRepository->findByReviewedUuid($reviewedUuid)->toArray();

        if (empty($reviews)) {
            throw new NoContentException("No se han encontrado reviews");
        }

        return $reviews;
    }
}
