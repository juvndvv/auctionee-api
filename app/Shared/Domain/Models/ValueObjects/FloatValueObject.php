<?php

namespace App\Shared\Domain\Models\ValueObjects;

abstract class FloatValueObject
{
    public function __construct(protected float $value) {
        self::ensureIsPositive($value);
    }

    final public function value(): float
    {
        return $this->value;
    }

    public static function ensureIsPositive(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva");
        }
    }
}
