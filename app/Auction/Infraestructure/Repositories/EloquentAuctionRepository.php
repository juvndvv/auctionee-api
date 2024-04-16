<?php

namespace App\Auction\Infraestructure\Repositories;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Infraestructure\Repositories\Models\EloquentAuctionModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentAuctionRepository implements AuctionRepositoryPort
{
    public function findAll(): Collection
    {
        return EloquentAuctionModel::all();
    }

    public function find($id): Model
    {
        return EloquentAuctionModel::query()->findOrFail($id);
    }

    public function create($attributes): Model
    {
        return EloquentAuctionModel::query()->create($attributes);
    }

    public function deleteById($id): Model
    {
        return EloquentAuctionModel::query()->findOrFail($id)->delete();
    }
}
