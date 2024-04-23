<?php

namespace App\Financial\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentWalletModel extends Model
{
    protected $table = 'wallets';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'amount',
        'user_uuid',
        'created_at',
        'updated_at'
    ];
}
