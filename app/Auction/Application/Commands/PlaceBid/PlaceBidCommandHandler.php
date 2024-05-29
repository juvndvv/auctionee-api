<?php

namespace App\Auction\Application\Commands\PlaceBid;

use App\Auction\Domain\Models\Bid\Bid;
use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Auction\Domain\Services\PlaceBidService;
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

        dd($amount);

        // Crea y ejecuta el servicio de dominio
        $placeBidService = PlaceBidService::create(
            $this->walletRepository,
            $this->bidRepository,
            $userUuid,
            $amount,
            $auctionUuid
        );
        $placeBidService->execute();

        // Actualiza datos en DB de la wallet del nuevo top bidder y publica eventos
        $topBidderWallet = $placeBidService->topBidderWallet();

        $this->walletRepository->updateAmount(
            $topBidderWallet->uuid(),
            $topBidderWallet->balance()
        );
        $this->walletRepository->updateBlockedAmount(
            $topBidderWallet->uuid(),
            $topBidderWallet->blockedBalance()
        );

        $this->eventBus->dispatch(...$topBidderWallet->pullDomainEvents());

        // Actualiza datos en DB de la wallet del anterior top bidder si existe y publica eventos
        if ($placeBidService->hasPreviousTopBidderWallet()) {
            $previousTopBidderWallet = $placeBidService->previousTopBidderWallet();

            $this->walletRepository->updateAmount(
                $previousTopBidderWallet->uuid(),
                $previousTopBidderWallet->balance()
            );
            $this->walletRepository->updateBlockedAmount(
                $previousTopBidderWallet->uuid(),
                $previousTopBidderWallet->blockedBalance()
            );

            $this->eventBus->dispatch(...$previousTopBidderWallet->pullDomainEvents());
        }

        // Inserta la nueva puja y publica eventos
        $topBid = $placeBidService->topBid();
        $this->bidRepository->create($topBid->toPrimitives());
        $this->eventBus->dispatch(...$topBid->pullDomainEvents());
    }
}
