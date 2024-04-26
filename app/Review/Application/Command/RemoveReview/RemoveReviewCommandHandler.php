<?php

namespace App\Review\Application\Command\RemoveReview;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\EventBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RemoveReviewCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryPort $reviewRepository,
        private readonly EventBus $eventBus)
    {}

    public function __invoke(RemoveReviewCommand $command)
    {
        try {
            $uuid = $command->uuid();

            // Fetch data
            $reviewDb = $this->reviewRepository->findByUuid($uuid);

            // Use case
            $review = Review::fromPrimitives($reviewDb->toArray());
            $review->delete();

            // Persistence
            $this->reviewRepository->remove($review->uuid());

            // Events
            $this->eventBus->dispatch(...$review->pullDomainEvents());

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("La review con uuid {$uuid} no existe");
        }

    }
}
