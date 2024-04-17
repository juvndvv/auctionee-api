<?php

namespace App\Authentication\Domain\Models\ValueObjects;

class UserPassword
{
    public readonly string $value;

    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(string $value): void
    {
        // TODO implementar
    }

    public function value(): string
    {
        return $this->value;
    }
}
