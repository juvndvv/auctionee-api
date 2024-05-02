<?php

namespace App\Auction\Application\Commands\UpdateAuctionStartingPrice;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionStartingPriceCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort  $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionStartingPriceCommand $command): void
    {
        $uuid = $command->uuid();
        $startingPrice = $command->startingPrice();

        $auction = $this->auctionRepository->findByUuid($uuid);
        $auction->updateStartingPrice($startingPrice);
        $this->auctionRepository->updateStartingPrice($uuid, $startingPrice);
        $this->eventBus->dispatch(...$auction->pullDomainEvents());
    }
}
