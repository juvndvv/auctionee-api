<?php

namespace App\Retention\EventMonitoring\Infraestructure\Repositories;

use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Infraestructure\Repositories\Models\EloquentEventModel;

class EloquentEventRepository implements EventRepositoryPort
{

    public function create(array $data)
    {
        EloquentEventModel::query()->create($data);
    }

    public function findAll()
    {
        return EloquentEventModel::all();
    }
}
