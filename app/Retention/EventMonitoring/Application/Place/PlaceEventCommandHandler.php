<?php

namespace App\Retention\EventMonitoring\Application\Place;

use App\Retention\EventMonitoring\Domain\Models\Event;
use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;

class PlaceEventCommandHandler
{
    public function __construct(private readonly EventRepositoryPort $eventRepository)
    {}

    public function __invoke(PlaceEventCommand $command)
    {
        $uuid = $command->uuid();
        $type = $command->type();
        $message = $command->message();
        $ocurredOn = $command->ocurredOn();

        $this->eventRepository->create([
            'uuid' => $uuid,
            'type' => $type,
            'message' => $message,
            'ocurred_on' => $ocurredOn]);
    }
}
