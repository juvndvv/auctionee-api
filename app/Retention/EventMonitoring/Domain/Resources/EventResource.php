<?php

namespace App\Retention\EventMonitoring\Domain\Resources;

use App\Retention\EventMonitoring\Domain\Models\Event;

class EventResource
{
    public static function fromArray(array $data)
    {
        return [
            Event::SERIALIZED_TYPE => $data[Event::SERIALIZED_TYPE],
            Event::SERIALIZED_PAYLOAD => $data[Event::SERIALIZED_PAYLOAD],
            Event::SERIALIZED_OCCURRED_ON => $data[Event::SERIALIZED_OCCURRED_ON],
        ];
    }
}
