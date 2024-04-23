<?php

namespace App\Review\Infraestructure\Repositories;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infraestructure\Repositories\Models\EloquentReviewModel;

class ReviewEloquentRepository implements ReviewRepositoryPort
{
    public function findByUserUuid(string $userUuid)
    {
        return EloquentReviewModel::query()
            ->select(
                "users.username",
                "users.avatar",
                "reviews.rating",
                "reviews.description",
                "reviews.created_at")
            ->join("users", "users.uuid", "=", "reviews.reviewer_uuid")
            ->get();
    }

    public function create(array $data)
    {
        return EloquentReviewModel::query()->create($data);
    }

    public function updateRating($uuid, int $rating)
    {
        return EloquentReviewModel::query()->where('uuid', $uuid)->update(['rating' => $rating]);
    }

    public function updateDescription(string $uuid, string $description)
    {
        return EloquentReviewModel::query()->where('uuid', $uuid)->update(['description' => $description]);
    }
}
