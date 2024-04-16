<?php

namespace App\Auction\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentAuctionModel extends Model
{
    use HasFactory;

    protected $table = "auctions";

    protected $fillable = [
        'name',
        'description',
        'price',
        'initialDate'
    ];
}
