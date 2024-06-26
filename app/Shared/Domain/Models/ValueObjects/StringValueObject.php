<?php

namespace App\Shared\Domain\Models\ValueObjects;


use InvalidArgumentException;

abstract class StringValueObject
{
    public function __construct(protected string $value, protected string $reference = "") {
        self::ensureIsValid($value, $reference);
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public static function ensureIsValid(string $value, string $reference): void
    {
        if (strlen($value) < 3) {
            throw new InvalidArgumentException(sprintf("El valor de %s debe tener al menos 3 caracteres.", $reference));
        }

        if (strlen($value) > 255) {
            throw new InvalidArgumentException(sprintf("El valor de %s debe tener al menos 255 caracteres.", $reference));
        }
    }
}
