<?php

namespace App\Auction\Domain\Services;

use App\Auction\Domain\Models\Bid\Bid;
use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Domain\Exceptions\NoContentException;

final class PlaceBidService
{
    private Wallet $topBidderWallet;
    private Wallet $previousTopBidderWallet;
    private Bid $topBid;

    public function __construct(
        private readonly WalletRepositoryPort $walletRepository,
        private readonly BidRepositoryPort    $bidRepository,
        private readonly string               $topBidderUuid,
        private readonly float                $topBidAmount,
        private readonly string               $auctionUuid
    )
    {}

    /**
     * Bloquea el dinero de la wallet, desbloquea el dinero de la wallet, desbloquea el dinero
     * de la wallet de la puja anterior y crea la nueva puja
     *
     * @return void
     */
    public function execute(): void
    {
        // Bloquea el dinero de la wallet
        $this->topBidderWallet = $this->walletRepository->findByUserUuid($this->topBidderUuid);
        $this->topBidderWallet->blockBalance($this->topBidAmount);

        // Desbloquea el dinero de la wallet de la puja anterior si existe
        try {
            $previousTopBid = $this->bidRepository->getTopBidOrFail($this->auctionUuid);
            $this->previousTopBidderWallet = $this->walletRepository->findByUserUuid($previousTopBid->userUuid());
            $this->previousTopBidderWallet->unblockBalance($previousTopBid->amount());
        } catch (NoContentException) {}

        // Crea la puja
        $this->topBid = Bid::create($this->topBidAmount, $this->topBidderUuid, $this->auctionUuid);
    }

    public function topBidderWallet(): Wallet
    {
        return $this->topBidderWallet;
    }

    public function hasPreviousTopBidderWallet(): bool
    {
        return isset($this->previousTopBidderWallet);
    }

    public function previousTopBidderWallet(): Wallet
    {
        return $this->previousTopBidderWallet;
    }

    public function topBid(): Bid
    {
        return $this->topBid;
    }

    public static function create(
        WalletRepositoryPort $walletRepository,
        BidRepositoryPort    $bidRepository,
        string               $topBidderUuid,
        float                $topBidAmount,
        string               $auctionUuid
    ): self
    {
        return new self($walletRepository, $bidRepository, $topBidderUuid, $topBidAmount, $auctionUuid);
    }
}
