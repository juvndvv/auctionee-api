<?php

namespace App\Shared\Infraestructure\Bus;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;

final readonly class EventBus
{
    public function __construct(private EventRepositoryPort $eventRepository)
    {}

    public function dispatch(): void
    {
        foreach(func_get_args() as $event) {
            event($event);

            // Persist the event
            $this->eventRepository->create([
                'uuid' => $event->eventId,
                'type' => $event->eventName(),
                'payload' => json_encode($event->payload),
                'occurred_on' => date('Y-m-d H:i:s', strtotime($event->occurredOn))
            ]);
        }
    }
}
