<?php

namespace App\Auction\Application\Commands\UpdateAuctionDescription;

use App\Auction\Application\Commands\UpdateAuctionName\UpdateAuctionNameCommand;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionDescriptionCommandHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort  $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionDescriptionCommand $command): void
    {
        $uuid = $command->uuid();
        $description = $command->description();

        $auction = $this->auctionRepository->findByUuid($uuid);
        $auction->updateDescription($description);
        $this->auctionRepository->updateDescription($uuid, $description);
        $this->eventBus->dispatch(...$auction->pullDomainEvents());
    }
}
