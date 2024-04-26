<?php

namespace App\Financial\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentTransactionModel extends Model
{
    use HasUuids;

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
