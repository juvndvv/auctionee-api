<?php

namespace App\Shared\Domain\Bus\Events;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;

class EventBus
{
    public function __construct(private readonly EventRepositoryPort $eventRepository)
    {}

    public function dispatch(): void
    {
        foreach(func_get_args() as $event) {
            event($event);

            // Persist the event
            $this->eventRepository->create([
                'uuid' => $event->eventId,
                'type' => $event->eventName(),
                'message' => json_encode($event->message),
                'ocurred_on' => date('Y-m-d H:i:s', strtotime($event->ocurredOn))
            ]);
        }
    }
}
