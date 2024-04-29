<?php

namespace App\Review\Application\Command\UpdateRating;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Bus\EventBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

final class UpdateRatingCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateRatingCommand $command): void
    {
        $uuid = $command->uuid();
        $rating = $command->rating();

        $review = $this->reviewRepository->findByUuid($uuid);       // Query data
        $review->updateRating($rating);                             // Use case
        $this->reviewRepository->updateRating($uuid, $rating);      // Persistence
        $this->eventBus->dispatch(...$review->pullDomainEvents());  // Publish events
    }
}
