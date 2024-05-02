<?php

namespace App\Auction\Application\Commands\UpdateAuctionStartingDate;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionStartingDateCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort  $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionStartingDateCommand $command): void
    {
        $uuid = $command->uuid();
        $startingDate = $command->startingDate();

        $auction = $this->auctionRepository->findByUuid($uuid);
        $auction->updateStartingDate($startingDate);
        $this->auctionRepository->updateStartingDate($uuid, $startingDate);
        $this->eventBus->dispatch(...$auction->pullDomainEvents());
    }
}
