<?php

namespace App\Retention\EventMonitoring\Domain\Resources;

class EventResource
{
    public static function fromArray(array $data)
    {
        return [
            'type' => $data['type'],
            'message' => $data['message'],
            'ocurred_on' => $data['ocurred_on'],
        ];
    }
}
