<?php

namespace App\Auction\Application\Services;

use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AuctionService implements AuctionServicePort
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    ) {}

    public function findAll(): Collection
    {
        return $this->auctionRepository->findAll();
    }

    public function create(array $auction): Model
    {
        return $this->auctionRepository->create($auction);
    }

    public function findById(int $id): Model
    {
        return $this->auctionRepository->find($id);
    }

    public function deleteById(int $id): Model
    {
        return $this->auctionRepository->deleteById($id);
    }
}
