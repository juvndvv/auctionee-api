<?php

namespace App\Social\Infraestructure\Repositories\Models;

use App\Social\Domain\Models\Friendship;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentFriendshipModel extends Model
{
    use HasUuids;

    protected $table = 'friendships';

    protected $primaryKey = Friendship::SERIALIZED_UUID;

    protected $fillable = [
        Friendship::SERIALIZED_UUID,
        Friendship::SERIALIZED_LEFT_UUID,
        Friendship::SERIALIZED_RIGHT_UUID,
    ];
}
