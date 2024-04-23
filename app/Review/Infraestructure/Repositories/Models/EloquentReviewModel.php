<?php

namespace App\Review\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentReviewModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reviews';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'reviewer_id',
        'reviewer_id',
        'review',
        'rating'
    ];
}
