<?php

namespace App\Review\Application\PlaceReview;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Domain\Resources\ReviewDetailsResource;
use App\Shared\Domain\Bus\Events\EventBus;

class PlaceReviewCommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository,
        private readonly EventBus $eventBus
    ) {}

    public function __invoke(PlaceReviewCommand $command): void
    {
        $rating = $command->rating();
        $description = $command->description();
        $reviewerUuid = $command->reviewerUuid();
        $reviewedUuid = $command->reviewedUuid();

        // Use case
        $review = Review::create($rating, $description, $reviewerUuid, $reviewedUuid);

        // Persistence
        $this->reviewRepository->create($review->toPrimitives());

        // Publish events
        $this->eventBus->dispatch(...$review->pullDomainEvents());
    }
}
