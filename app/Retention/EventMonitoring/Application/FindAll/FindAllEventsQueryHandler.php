<?php

namespace App\Retention\EventMonitoring\Application\FindAll;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Domain\Resources\EventResource;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;

class FindAllEventsQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly EventRepositoryPort $eventRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllEventsQuery $query): array
    {
        $events = $this->eventRepository->findAll();

        // Map to resource
        $eventResourceArr = [];

        foreach ($events as $event) {
            $eventResourceArr[] = EventResource::fromArray($event->toArray());
        }

        return $eventResourceArr;
    }
}
