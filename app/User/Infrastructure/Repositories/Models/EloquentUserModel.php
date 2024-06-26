<?php

namespace App\User\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

final class EloquentUserModel extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUuids;

    protected $table = "users";

    protected $primaryKey = "uuid";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'birth',
        'role'
    ];
}
