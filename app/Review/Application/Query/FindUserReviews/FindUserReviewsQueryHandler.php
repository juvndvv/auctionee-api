<?php

namespace App\Review\Application\Query\FindUserReviews;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Domain\Projections\ReviewDetailsProjection;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

final class FindUserReviewsQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository
    )
    {}

    /**
     * @returns Collection<ReviewDetailsProjection>
     * @throws NotFoundException
     */
    public function __invoke(FindUserReviewsQuery $query): Collection
    {
        $reviewedUuid = $query->reviewedUuid();
        return $this->reviewRepository->findByReviewedUuid($reviewedUuid);
    }
}
