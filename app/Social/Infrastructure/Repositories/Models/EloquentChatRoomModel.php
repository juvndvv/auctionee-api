<?php

namespace App\Social\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class EloquentChatRoomModel extends Model
{
    use HasUuids;

    protected $table = 'chat_rooms';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'left_uuid',
        'right_uuid',
        'created_at',
        'updated_at'
    ];
}
