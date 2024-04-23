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
use App\UserManagement\Domain\Models\ValueObjects\UserId;

class Review extends AggregateRoot
{
    private ReviewUuid $uuid;
    private ReviewRating $rating;
    private ReviewDescription $description;
    private UserId $reviewerId;
    private UserId $reviewedId;

    public function __construct(string $uuid, int $rating, string $description, string $reviewerId, string $reviewedId)
    {
        $this->uuid = new ReviewUuid($uuid);
        $this->rating = new ReviewRating($rating);
        $this->description = new ReviewDescription($description);
        $this->reviewerId = new UserId($reviewerId);
        $this->reviewedId = new UserId($reviewedId);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['rating'],
            $data['description'],
            $data['reviewerId'],
            $data['reviewedId']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'uuid' => $this->uuid(),
            'rating' => $this->rating(),
            'description' => $this->description(),
            'reviewer_uuid' => $this->reviewerId(),
            'reviewed_uuid' => $this->reviewedId(),
        ];
    }

    // Use cases
    public static function create(string $rating, string $description, string $reviewerId, string $reviewedId): self
    {
        $generatedUuid = ReviewUuid::random();
        $review = new self(
            $generatedUuid,
            $rating,
            $description,
            $reviewerId,
            $reviewedId
        );

        $review->record(new ReviewPlacedEvent($review->toPrimitives(), now()->toString()));

        return $review;
    }

    public function delete(): void
    {
        $this->record(new ReviewRemovedEvent($this->toPrimitives(), now()->toString()));
    }

    public function updateRating(int $rating): void
    {
        $old = $this->rating();
        $this->rating = new ReviewRating($rating);
        $this->record(new RatingUpdatedEvent([
            'old' => $old,
            'new' => $rating
        ], now()->toString()));
    }

    public function updateDescription(string $description): void
    {
        $old = $this->rating();
        $this->description = new ReviewDescription($description);
        $this->record(new DescriptionUpdatedEvent([
            'old' => $old,
            'new' => $description
        ], now()->toString()));
    }

    // Getters
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
}
