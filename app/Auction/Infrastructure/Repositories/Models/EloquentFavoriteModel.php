<?php

namespace App\Auction\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentFavoriteModel extends Model
{
    protected $table = 'user_auctions_favorites';
    protected $fillable = ['user_id', 'auction_id'];
}
