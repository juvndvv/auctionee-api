<?php

namespace App\Review\Infrastructure\Repositories;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Domain\Resources\ReviewDetailsResource;
use App\Review\Infrastructure\Repositories\Models\EloquentReviewModel;
use App\Shared\Infrastucture\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class ReviewEloquentRepository extends BaseRepository implements ReviewRepositoryPort
{
    public function findByUuid(string $uuid)
    {
        return EloquentReviewModel::query()->where("uuid", $uuid)->firstOrFail();
    }

    public function findByReviewerUuid(string $reviewerUuid): ReviewDetailsResource
    {
        $userDb = EloquentReviewModel::query()
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

        dd($userDb);
    }

    public function findByReviewedUuid(string $reviewedUuid): Collection
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

    public function create(array $data): void
    {
        EloquentReviewModel::query()->create($data);
    }

    public function updateRating($uuid, int $rating): void
    {
        EloquentReviewModel::query()->where('uuid', $uuid)->update(['rating' => $rating]);
    }

    public function updateDescription(string $uuid, string $description): void
    {
        EloquentReviewModel::query()->where('uuid', $uuid)->update(['description' => $description]);
    }

    public function remove(string $uuid): void
    {
        EloquentReviewModel::query()->where('uuid', $uuid)->delete();
    }

    public function findUserAverageRating(string $userUuid): float
    {
        return EloquentReviewModel::query()
            ->where("reviewed_uuid", "=", $userUuid)
            ->avg("rating");
    }
}
