<?php

namespace App\Auction\Application\Commands\PlaceBid;

use App\Auction\Domain\Models\Bid\Bid;
use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;

final class PlaceBidCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly BidRepositoryPort $bidRepository,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(PlaceBidCommand $command): void
    {
        $userUuid = $command->userUuid();
        $amount  = $command->amount();
        $auctionUuid = $command->auctionUuid();

        $bid = Bid::create($amount, $userUuid, $auctionUuid);
        $this->bidRepository->create($bid->toPrimitives());
        $this->eventBus->dispatch(...$bid->pullDomainEvents());
    }
}
