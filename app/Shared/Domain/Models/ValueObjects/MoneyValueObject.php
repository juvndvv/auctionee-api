<?php

namespace App\Shared\Domain\Models\ValueObjects;

use InvalidArgumentException;

abstract class MoneyValueObject
{
    public function __construct(protected float $value)
    {
        self::ensureIsPositive($value);
    }

    final public function value(): int
    {
        return $this->value;
    }

    final public function isBiggerThan(self $other): bool
    {
        return $this->value() > $other->value();
    }

    public static function ensureIsPositive(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva");
        }
    }
}
