<?php

namespace App\Shared\Domain\Models\ValueObjects;

class JsonValueObject
{
    public function __construct(protected readonly string $value)
    {
        self::ensureIsValid($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function ensureIsValid(string $value): void
    {
        if (!json_validate($value)) {
            throw new \InvalidArgumentException("El JSON no es valido");
        }
    }
}
