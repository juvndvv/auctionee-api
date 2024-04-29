<?php

namespace App\Review\Application\Command\PlaceReview;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Infrastructure\Bus\EventBus;

final class PlaceReviewCommandHandler extends QueryHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort   $reviewRepository,
        private readonly EventBus               $eventBus
    ) {}

    public function __invoke(PlaceReviewCommand $command): void
    {
        $rating = $command->rating();
        $description = $command->description();
        $reviewerUuid = $command->reviewerUuid();
        $reviewedUuid = $command->reviewedUuid();

        $review = Review::create($rating, $description, $reviewerUuid, $reviewedUuid);  // Use case
        $this->reviewRepository->create($review->toPrimitives());                       // Persistence
        $this->eventBus->dispatch(...$review->pullDomainEvents());                      // Publish events
    }
}
