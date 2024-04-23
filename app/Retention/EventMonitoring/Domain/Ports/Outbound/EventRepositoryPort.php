<?php

namespace App\Retention\EventMonitoring\Domain\Ports\Outbound;

interface EventRepositoryPort
{
    public function create(array $data);
    public function findAll();
}
