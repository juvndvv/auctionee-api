<?php

namespace App\Auction\Infrastructure\Repositories\Models;

use App\Auction\Domain\Models\Auction\Auction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class EloquentAuctionModel extends Model
{
    use HasUuids;

    protected $table = 'auctions';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        Auction::UUID,
        Auction::CATEGORY_UUID,
        Auction::USER_UUID,
        Auction::NAME,
        Auction::DESCRIPTION,
        Auction::STATUS,
        Auction::STARTING_PRICE,
        Auction::STARTING_DATE,
        Auction::DURATION,
        Auction::AVATAR
    ];
}
