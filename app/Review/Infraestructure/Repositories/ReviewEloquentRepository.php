<?php

namespace App\Review\Infraestructure\Repositories;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infraestructure\Repositories\Models\EloquentReviewModel;
use App\Shared\Infraestructure\Repositories\BaseRepository;

class ReviewEloquentRepository extends BaseRepository implements ReviewRepositoryPort
{
    public function findByUuid(string $uuid)
    {
        return EloquentReviewModel::query()->where("uuid", $uuid)->firstOrFail();
    }

    public function findByReviewerUuid(string $reviewerUuid)
    {
        return EloquentReviewModel::query()
            ->select(
                "reviews.uuid",
                "users.username",
                "users.avatar",
                "reviews.rating",
                "reviews.description",
                "reviews.created_at")
            ->join("users", "users.uuid", "=", "reviews.reviewed_uuid")
            ->where("reviews.reviewer_uuid", $reviewerUuid)
            ->get();
    }

    public function findByReviewedUuid(string $reviewedUuid)
    {
        return EloquentReviewModel::query()
            ->select(
                "reviews.uuid",
                "users.username",
                "users.avatar",
                "reviews.rating",
                "reviews.description",
                "reviews.created_at")
            ->join("users", "users.uuid", "=", "reviews.reviewer_uuid")
            ->where("reviews.reviewed_uuid", $reviewedUuid)
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

    public function remove(string $uuid)
    {
        return EloquentReviewModel::query()->where('uuid', $uuid)->delete();
    }

    public function findUserAverageRating(string $userUuid)
    {
        return EloquentReviewModel::query()
            ->where("reviewed_uuid", "=", $userUuid)
            ->avg("rating");
    }
}
