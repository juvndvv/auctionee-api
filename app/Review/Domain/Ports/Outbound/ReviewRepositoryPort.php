<?php

namespace App\Review\Domain\Ports\Outbound;

use App\Review\Domain\Models\Review;

interface ReviewRepositoryPort
{
    public function findByReviewedUuid(string $userUuid);
    public function create(array $data);
    public function updateRating($uuid, int $rating);
    public function updateDescription(string $uuid, string $description);
}
