<?php

namespace App\Review\Domain\Ports\Outbound;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Projections\ReviewDetailsProjection;
use App\Review\Domain\Projections\UserAverageProjection;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Support\Collection;

interface ReviewRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param int $offset
     * @param int $limit
     * @return Collection<Review>
     * @throws NoContentException
     */
    public function findAll(int $offset = 0, int $limit = 20): Collection;

    /**
     * @param string $uuid
     * @return Review
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Review;

    /**
     * @param string $reviewerUuid
     * @return Collection<Review>
     * @throws NotFoundException
     */
    public function findByReviewerUuid(string $reviewerUuid): Collection;

    /**
     * @param string $reviewedUuid
     * @return Collection<ReviewDetailsProjection>
     * @throws NotFoundException
     */
    public function findByReviewedUuid(string $reviewedUuid): Collection;

    /**
     * @param $uuid
     * @param int $rating
     * @return void
     * @throws NotFoundException
     */
    public function updateRating($uuid, int $rating): void;

    /**
     * @param string $uuid
     * @param string $description
     * @return void
     * @throws NotFoundException
     */
    public function updateDescription(string $uuid, string $description): void;

    /**
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function remove(string $uuid): void;

    /**
     * @param string $userUuid
     * @return UserAverageProjection
     * @throws NotFoundException
     */
    public function findUserAverageRating(string $userUuid): UserAverageProjection;
}
