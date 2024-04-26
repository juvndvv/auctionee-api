<?php

namespace App\Retention\EventMonitoring\Application\FindAll;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Domain\Resources\EventResource;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;

class FindAllEventsQueryHandler extends QueryHandler
{
    public function __construct(private readonly EventRepositoryPort $eventRepository)
    {}

    public function __invoke(FindAllEventsQuery $query): array
    {
        $events = $this->eventRepository->findAll();

        if ($events->count() === 0) {
            throw new NoContentException("No se encontraron eventos");
        }

        // Map to resource
        $eventResourceArr = [];

        foreach ($events as $event) {
            $eventResourceArr[] = EventResource::fromArray($event->toArray());
        }

        return $eventResourceArr;
    }
}
