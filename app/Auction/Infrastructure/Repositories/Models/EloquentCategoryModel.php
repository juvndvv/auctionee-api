<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentCategoryModel extends Model
{
    use HasUuids;

    protected $table = 'categories';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'avatar',
    ];
}
