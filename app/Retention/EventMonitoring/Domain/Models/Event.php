<?php

namespace App\Retention\EventMonitoring\Domain\Models;

use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventMessage;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventOcurredOn;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventType;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventUuid;

class Event
{
    private readonly EventUuid $uuid;
    private readonly EventType $type;
    private readonly EventMessage $message;
    private readonly EventOcurredOn $occurredOn;

    public function __construct(string $uuid, string $type, string $message, string $occurredOn)
    {
        $this->uuid = new EventUuid($uuid);
        $this->type = new EventType($type);
        $this->message = new EventMessage($message);
        $this->occurredOn = new EventOcurredOn($occurredOn);
    }

    public static function fromPrimitives(array $data)
    {
        return new self(
            $data['uuid'],
            $data['type'],
            $data['message'],
            $data['occurredOn']
        );
    }

    public function toPrimitives()
    {
        return [
            'uuid' => $this->uuid(),
            'type' => $this->type(),
            'message' => $this->message(),
            'occurred_on' => $this->occurredOn()
        ];
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function type(): string
    {
        return $this->type->value();
    }

    public function message(): string
    {
        return $this->message->value();
    }

    public function occurredOn(): string
    {
        return $this->occurredOn->value();
    }
}
