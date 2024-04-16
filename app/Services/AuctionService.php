<?php

namespace App\Services;

use App\Repositories\AuctionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AuctionService
{

    public function __construct(
        private readonly AuctionRepository $auctionRepository
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


}
