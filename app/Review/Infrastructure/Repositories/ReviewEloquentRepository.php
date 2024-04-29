<?php

namespace App\Review\Infrastructure\Repositories;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infrastructure\Repositories\Models\EloquentReviewModel;
use App\Shared\Infrastucture\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class ReviewEloquentRepository extends BaseRepository implements ReviewRepositoryPort
{
    private const ENTITY_NAME = 'review';

    public function __construct()
    {
        $this->setBuilderFromModel(EloquentReviewModel::query()->getModel());
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

    public function findByReviewedUuid(string $reviewedUuid): Collection
    {
        $reviewDb = parent::findByFieldValue(Review::SERIALIZED_REVIEWED_UUID, $reviewedUuid);
        return $reviewDb->map(fn ($review) => Review::fromPrimitives($review->toArray()));
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

    public function findUserAverageRating(string $userUuid): float
    {
        return $this->builder
            ->where("reviewed_uuid", "=", $userUuid)
            ->avg("rating");
    }
}
