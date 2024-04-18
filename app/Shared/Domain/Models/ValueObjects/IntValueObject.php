<?php

namespace App\Shared\Domain\Models\ValueObjects;

use InvalidArgumentException;

abstract class IntValueObject
{
    public function __construct(protected int $value) {
        self::ensureIsPositive($value);
    }

    final public function value(): int
    {
        return $this->value;
    }

    public static function ensureIsPositive(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva");
        }
    }
}
