<?php

namespace App\Financial\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentWalletModel extends Model
{
    use HasUuids;

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
