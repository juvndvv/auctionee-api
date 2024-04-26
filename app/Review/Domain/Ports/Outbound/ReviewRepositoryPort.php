<?php

namespace App\Review\Domain\Ports\Outbound;

use App\Review\Domain\Models\Review;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;

interface ReviewRepositoryPort extends BaseRepositoryPort
{
    public function findByUuid(string $uuid);
    public function findByReviewerUuid(string $reviewerUuid);
    public function findByReviewedUuid(string $reviewedUuid);
    public function updateRating($uuid, int $rating);
    public function updateDescription(string $uuid, string $description);
    public function remove(string $uuid);
    public function findUserAverageRating(string $userUuid);
}
