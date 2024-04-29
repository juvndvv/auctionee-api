<?php

namespace App\Retention\EventMonitoring\Domain\Models;

use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventMessage;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventOcurredOn;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventType;
use App\Retention\EventMonitoring\Domain\Models\ValueObjects\EventUuid;

class Event
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_TYPE = 'type';
    public const string SERIALIZED_PAYLOAD = 'payload';
    public const string SERIALIZED_OCCURRED_ON = 'occurred_on';

    private readonly EventUuid $uuid;
    private readonly EventType $type;
    private readonly EventMessage $payload;
    private readonly EventOcurredOn $occurredOn;

    public function __construct(string $uuid, string $type, string $message, string $occurredOn)
    {
        $this->uuid = new EventUuid($uuid);
        $this->type = new EventType($type);
        $this->payload = new EventMessage($message);
        $this->occurredOn = new EventOcurredOn($occurredOn);
    }

    public static function fromPrimitives(array $data): Event
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_TYPE],
            $data[self::SERIALIZED_PAYLOAD],
            $data[self::SERIALIZED_OCCURRED_ON]
        );
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_TYPE => $this->type(),
            self::SERIALIZED_PAYLOAD => $this->message(),
            self::SERIALIZED_OCCURRED_ON => $this->occurredOn()
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

    public function payload(): string
    {
        return $this->payload->value();
    }

    public function occurredOn(): string
    {
        return $this->occurredOn->value();
    }
}
