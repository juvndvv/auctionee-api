<?php

namespace App\Authentication\Domain\Models\ValueObjects;

final readonly class UserId
{
    private readonly int $value;

    public function __construct(int $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(string $value): void
    {
        // TODO implementar
    }

    public function value(): int
    {
        return $this->value;
    }
}
