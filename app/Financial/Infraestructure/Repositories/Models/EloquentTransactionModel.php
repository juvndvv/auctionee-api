<?php

namespace App\Financial\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentTransactionModel extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'remitent_wallet_uuid',
        'destination_wallet_uuid',
        'amount',
        'created_at',
        'updated_at'
    ];
}
