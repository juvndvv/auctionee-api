<?php

namespace App\Review\Domain\Models;

use App\Review\Domain\Events\DescriptionUpdatedEvent;
use App\Review\Domain\Events\RatingUpdatedEvent;
use App\Review\Domain\Events\ReviewPlacedEvent;
use App\Review\Domain\Events\ReviewRemovedEvent;
use App\Review\Domain\Models\ValueObjects\ReviewDescription;
use App\Review\Domain\Models\ValueObjects\ReviewRating;
use App\Review\Domain\Models\ValueObjects\ReviewUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserUuid;

final class Review extends AggregateRoot
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_REVIEWER_UUID = 'reviewer_uuid';
    public const string SERIALIZED_REVIEWED_UUID = 'reviewed_uuid';
    public const string SERIALIZED_DESCRIPTION = 'description';
    public const string SERIALIZED_RATING = 'rating';

    private ReviewUuid $uuid;
    private ReviewRating $rating;
    private ReviewDescription $description;
    private UserUuid $reviewerId;
    private UserUuid $reviewedId;

    public function __construct(
        string  $uuid,
        int     $rating,
        string  $description,
        string  $reviewerId,
        string  $reviewedId
    )
    {
        $this->uuid = new ReviewUuid($uuid);
        $this->rating = new ReviewRating($rating);
        $this->description = new ReviewDescription($description);
        $this->reviewerId = new UserUuid($reviewerId);
        $this->reviewedId = new UserUuid($reviewedId);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function rating(): int
    {
        return $this->rating->value();
    }

    public function description(): string
    {
        return $this->description->value();
    }

    public function reviewerId(): string
    {
        return $this->reviewerId->value();
    }

    public function reviewedId(): string
    {
        return $this->reviewedId->value();
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_RATING => $this->rating(),
            self::SERIALIZED_DESCRIPTION => $this->description(),
            self::SERIALIZED_REVIEWER_UUID => $this->reviewerId(),
            self::SERIALIZED_REVIEWED_UUID => $this->reviewedId(),
        ];
    }

    public function delete(): void
    {
        $this->record(new ReviewRemovedEvent($this->toPrimitives(), now()->toString()));
    }

    public function updateRating(int $rating): void
    {
        $old = $this->rating();
        $this->rating = new ReviewRating($rating);
        $this->record(new RatingUpdatedEvent($this->reviewedId(), [
            'old' => $old,
            'new' => $rating
        ], now()->toString()));
    }

    public function updateDescription(string $description): void
    {
        $old = $this->description();
        $this->description = new ReviewDescription($description);
        $this->record(new DescriptionUpdatedEvent($this->reviewedId(), [
            'old' => $old,
            'new' => $description
        ], now()->toString()));
    }

    public static function create(
        string $rating,
        string $description,
        string $reviewerId,
        string $reviewedId
    ): self
    {
        $generatedUuid = ReviewUuid::random();
        $review = new self(
            $generatedUuid,
            $rating,
            $description,
            $reviewerId,
            $reviewedId
        );

        $review->record(new ReviewPlacedEvent($reviewedId, $review->toPrimitives(), now()->toString()));

        return $review;
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_RATING],
            $data[self::SERIALIZED_DESCRIPTION],
            $data[self::SERIALIZED_REVIEWER_UUID],
            $data[self::SERIALIZED_REVIEWED_UUID],
        );
    }
}
