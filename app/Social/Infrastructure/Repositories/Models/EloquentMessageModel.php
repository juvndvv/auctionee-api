<?php

namespace App\Social\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EloquentMessageModel extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'chat_messages';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'chat_room_uuid',
        'sender_uuid',
        'content'
    ];
}
