<?php

namespace App\Financial\Infrastructure\Repositories\Models;

use App\Financial\Domain\Models\Wallet;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentWalletModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'wallets';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        Wallet::UUID,
        Wallet::BALANCE,
        Wallet::BLOCKED_BALANCE,
        Wallet::USER_UUID,
        'created_at',
        'updated_at'
    ];
}
