<?php

namespace App\Retention\EventMonitoring\Infrastructure\Repositories\Models;

use App\Retention\EventMonitoring\Domain\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EloquentEventModel extends Model
{
    protected $table = "events";

    protected $primaryKey = Event::SERIALIZED_UUID;

    protected $fillable = [
        Event::SERIALIZED_UUID,
        Event::SERIALIZED_TYPE,
        Event::SERIALIZED_PAYLOAD,
        Event::SERIALIZED_OCCURRED_ON
    ];
}
