<?php

namespace App\Review\Application\Command\RemoveReview;

use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class RemoveReviewCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository,
        private readonly EventBus $eventBus)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(RemoveReviewCommand $command): void
    {
            $uuid = $command->uuid();

            $review = $this->reviewRepository->findByUuid($uuid);       // Query data
            $review->delete();                                          // Use case
            $this->reviewRepository->remove($review->uuid());           // Persistence
            $this->eventBus->dispatch(...$review->pullDomainEvents());  // Publish events
    }
}
