<?php

namespace App\Retention\EventMonitoring\Infraestructure\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentEventModel extends Model
{
    protected $table = "events";

    protected $primaryKey = "uuid";

    protected $fillable = [
        "uuid",
        "type",
        "message",
        "ocurred_on"
    ];
}
