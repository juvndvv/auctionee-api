<?php

namespace App\Review\Application\UpdateRating;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class UpdateRatingCommandHandler extends CommandHandler
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
        try {
            $uuid = $command->uuid();
            $rating = $command->rating();

            $dbReview = $this->reviewRepository->findByUuid($uuid);

            $review = Review::fromPrimitives($dbReview->toArray());
            $review->updateRating($rating);

            $updates = $this->reviewRepository->updateRating($uuid, $rating);

            if ($updates < 1) {
                throw new RuntimeException("Ha ocurrido un error al actualizar el rating");
            }

            $this->eventBus->dispatch(...$review->pullDomainEvents());

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("La review con uuid {$uuid} no existe");
        }
    }
}
