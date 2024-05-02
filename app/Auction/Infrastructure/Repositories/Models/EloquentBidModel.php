<?php

namespace App\Auction\Infrastructure\Repositories\Models;

use App\Auction\Domain\Models\Bid\Bid;
use Illuminate\Database\Eloquent\Model;

final class EloquentBidModel extends Model
{
    protected $table = 'bids';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        Bid::UUID,
        Bid::AMOUNT,
        Bid::USER_UUID,
        Bid::AUCTION_UUID
    ];
}
