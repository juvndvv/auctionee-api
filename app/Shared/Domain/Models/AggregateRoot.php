<?php

namespace App\Shared\Domain\Models;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record($domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
