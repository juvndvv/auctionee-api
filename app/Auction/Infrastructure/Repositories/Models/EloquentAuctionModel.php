<?php

namespace App\Auction\Infrastructure\Repositories\Models;

use App\Auction\Domain\Models\Auction\Auction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentAuctionModel extends Model
{
    use HasUuids;

    protected $table = 'auctions';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        Auction::SERIALIZED_UUID,
        Auction::SERIALIZED_CATEGORY_UUID,
        Auction::SERIALIZED_USER_UUID,
        Auction::SERIALIZED_NAME,
        Auction::SERIALIZED_DESCRIPTION,
        Auction::SERIALIZED_STATUS,
        Auction::SERIALIZED_STARTING_PRICE,
        Auction::SERIALIZED_STARTING_DATE,
        Auction::SERIALIZED_DURATION
    ];
}
