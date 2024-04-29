<?php

namespace App\Review\Application\Command\UpdateDescription;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Bus\EventBus;
use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateDescriptionCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateDescriptionCommand $command): void
    {
            $uuid = $command->uuid();
            $description = $command->description();

            $review = $this->reviewRepository->findByUuid($uuid);               // Query data
            $review->updateDescription($description);                           // Use case
            $this->reviewRepository->updateDescription($uuid, $description);    // Persistence
            $this->eventBus->dispatch(...$review->pullDomainEvents());          // Publish event
    }
}
