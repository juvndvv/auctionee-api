<?php

namespace App\Auction\Application\Commands\UpdateAuctionDuration;

use App\Auction\Application\Commands\UpdateAuctionName\UpdateAuctionNameCommand;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionDurationCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort  $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionDurationCommand $command): void
    {
        $uuid = $command->uuid();
        $duration = $command->duration();

        $auction = $this->auctionRepository->findByUuid($uuid);
        $auction->updateDuration($duration);
        $this->auctionRepository->updateDuration($uuid, $duration);
        $this->eventBus->dispatch(...$auction->pullDomainEvents());
    }
}
