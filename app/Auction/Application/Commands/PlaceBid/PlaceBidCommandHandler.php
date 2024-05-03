<?php

namespace App\Auction\Application\Commands\PlaceBid;

use App\Auction\Domain\Models\Bid\Bid;
use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;

final class PlaceBidCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort   $walletRepository,
        private readonly BidRepositoryPort      $bidRepository,
        private readonly EventBus               $eventBus
    )
    {}

    /**
     * @throws NotEnoughFoundsException
     */
    public function __invoke(PlaceBidCommand $command): void
    {
        $userUuid = $command->userUuid();
        $amount  = $command->amount();
        $auctionUuid = $command->auctionUuid();

        // Fetch data
        $bid = Bid::create($amount, $userUuid, $auctionUuid);
        $wallet = $this->walletRepository->findByUserUuid($userUuid);

        // Use case
        $wallet->withdraw($bid->amount());

        // Persistence
        $this->walletRepository->updateAmount($wallet->uuid(), $wallet->balance());
        $this->bidRepository->create($bid->toPrimitives());

        // Publish event
        $this->eventBus->dispatch(...$bid->pullDomainEvents());
    }
}
