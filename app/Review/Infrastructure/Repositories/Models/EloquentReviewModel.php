<?php

namespace App\Review\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EloquentReviewModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reviews';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'reviewer_uuid',
        'reviewed_uuid',
        'description',
        'rating'
    ];
}
