<?php

namespace App\Shared\Infrastructure\Bus;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Social\Domain\Events\MessageDeletedEvent;
use App\Social\Domain\Events\MessageSentEvent;

final readonly class EventBus
{
    public function __construct(private EventRepositoryPort $eventRepository)
    {}

    public function dispatch(): void
    {
        foreach(func_get_args() as $event) {
            event($event);

            // Persist the event if needed
            $unsavedEvents = [MessageSentEvent::eventName(), MessageDeletedEvent::eventName()];
            if (!in_array($event->eventName(), $unsavedEvents)) {
                $this->eventRepository->create([
                    'uuid' => $event->eventId,
                    'type' => $event->eventName(),
                    'payload' => json_encode($event->payload),
                    'occurred_on' => date('Y-m-d H:i:s', strtotime($event->occurredOn))
                ]);
            }

        }
    }
}
