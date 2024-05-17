<?php

namespace App\Review\Infrastructure\Repositories;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Domain\Projections\ReviewDetailsProjection;
use App\Review\Domain\Projections\UserAverageProjection;
use App\Review\Infrastructure\Repositories\Models\EloquentReviewModel;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class EloquentReviewRepository extends BaseRepository implements ReviewRepositoryPort
{
    private const string ENTITY_NAME = 'review';

    public function __construct()
    {
        $this->setModel(EloquentReviewModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    public function findAll(int $offset = 0, int $limit = 20): Collection
    {
        $reviews = parent::findAll($offset, $limit);
        return $reviews->map(fn ($review) => Review::fromPrimitives($review->toArray()));
    }

    public function findByUuid(string $uuid): Review
    {
        $reviewDb = parent::findByFieldValue(Review::SERIALIZED_UUID, $uuid)['0'];
        return Review::fromPrimitives($reviewDb->toArray());
    }

    public function findByReviewerUuid(string $reviewerUuid): Collection
    {
        $reviewDb = parent::findByFieldValue(Review::SERIALIZED_REVIEWER_UUID, $reviewerUuid);
        return $reviewDb->map(fn ($review) => Review::fromPrimitives($review->toArray()));
    }

    public function findByReviewedUuid(string $reviewedUuid, int $offset, int $limit): Collection
    {
        $reviews = EloquentReviewModel::query()
            ->select(
                "reviews.uuid as uuid",
                "users.uuid as user_uuid",
                "users.username as username",
                "users.avatar as avatar",
                "reviews.rating as rating",
                "reviews.description as description",
                "reviews.created_at as created_at")
            ->join("users", "users.uuid", "=", "reviews.reviewer_uuid")
            ->where("reviews.reviewed_uuid", $reviewedUuid)
            ->offset($offset)
            ->limit($limit)
            ->get();

        if ($reviews->count() === 0) {
            throw new NoContentException();
        }

        return $reviews->map(
            fn ($review) => ReviewDetailsProjection::create(
                $review['uuid'],
                $review['user_uuid'],
                $review['username'],
                $review['avatar'],
                $review['rating'],
                $review['description'],
                now()->toString()
            ));
    }

    public function updateRating($uuid, int $rating): void
    {
        parent::updateFieldByPrimaryKey($uuid, Review::SERIALIZED_RATING, $rating);
    }

    public function updateDescription(string $uuid, string $description): void
    {
        parent::updateFieldByPrimaryKey($uuid, Review::SERIALIZED_DESCRIPTION, $description);
    }

    public function remove(string $uuid): void
    {
        parent::deleteByPrimaryKey($uuid);
    }

    public function findUserAverageRating(string $userUuid): UserAverageProjection
    {
        return UserAverageProjection::create(floatval($this->model
            ->where("reviewed_uuid", "=", $userUuid)
            ->avg("rating")));
    }
}
