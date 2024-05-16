<?php

namespace App\Auction\Application\Commands\UpdateAuctionName;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionNameCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort  $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionNameCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->name();

        $auction = $this->auctionRepository->findModelByUuid($uuid);
        $auction->updateName($name);
        $this->auctionRepository->updateName($uuid, $name);
        $this->eventBus->dispatch(...$auction->pullDomainEvents());
    }
}
