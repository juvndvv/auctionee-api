<?php

namespace App\Repositories;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AuctionEloquentRepository implements AuctionRepository
{

    public function findAll(): Collection
    {
        return Auction::all();
    }

    public function find($id): Model
    {
        return Auction::query()->findOrFail($id);
    }

    public function create($attributes)
    {
        return Auction::query()->create($attributes);
    }

    public function deleteById($id)
    {
        return Auction::query()->findOrFail($id)->delete();
    }
}
