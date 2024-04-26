<?php

namespace App\Review\Application\UpdateDescription;

use App\Review\Domain\Models\Review;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateDescriptionCommandHandler extends CommandHandler
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
        try {
            $uuid = $command->uuid();
            $description = $command->description();

            $dbReview = $this->reviewRepository->findByUuid($uuid);

            $review = Review::fromPrimitives($dbReview->toArray());
            $review->updateDescription($description);

            $updates = $this->reviewRepository->updateDescription($uuid, $description);

            if ($updates < 1) {
                throw new RuntimeException("Ha ocurrido un error al actualizar la descripcion");
            }

            $this->eventBus->dispatch(...$review->pullDomainEvents());

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("La review con uuid {$uuid} no existe");
        }
    }
}
