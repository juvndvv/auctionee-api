<?php

namespace App\UserManagement\Domain\Events;

use App\Shared\Domain\Bus\Events\DomainEvent;

class UserUpdatedEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $field,
        private readonly string $old,
        private readonly string $new,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['field'],
            $body['old'],
            $body['new']
        );
    }

    public static function eventName(): string
    {
        return 'user.updated';
    }

    public function toPrimitives(): array
    {
        return [
            'aggregateId' => $this->aggregateId(),
            'field' => $this->field,
            'old' => $this->old,
            'new' => $this->new
        ];
    }

    public function field(): string
    {
        return $this->field;
    }

    public function old(): string
    {
        return $this->old;
    }

    public function new(): string
    {
        return $this->new;
    }
}
