<?php

namespace App\Retention\EventMonitoring\Application\FindAll;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Shared\Domain\Exceptions\NoContentException;

class FindAllEventsQueryHandler
{
    public function __construct(private readonly EventRepositoryPort $eventRepository)
    {}

    public function __invoke(FindAllEventsQuery $query)
    {
        $events = $this->eventRepository->findAll();

        if ($events->count() === 0) {
            throw new NoContentException("No se encontraron eventos");
        }

        return $events;
    }
}
