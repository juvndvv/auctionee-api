<?php

namespace App\Retention\EventMonitoring\Infrastructure\Repositories;

use App\Retention\EventMonitoring\Domain\Models\Event;
use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Infrastructure\Repositories\Models\EloquentEventModel;
use App\Shared\Infrastucture\Repositories\BaseRepository;

class EloquentEventRepository extends BaseRepository implements EventRepositoryPort
{
    private const ENTITY_NAME = Event::class;

    public function __construct()
    {
        $this->setEntityName(self::ENTITY_NAME);
        $this->setBuilderFromModel(EloquentEventModel::query()->getModel());
    }
}
