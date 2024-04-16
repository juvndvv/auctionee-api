<?php

namespace App\Shared\Domain\Models\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidValueException;

final class Description
{
    private string $value;

    /**
     * @throws InvalidValueException
     */
    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidValueException
     */
    public static function ensureIsValid(string $value): void
    {
        if (strlen($value) < 20 || strlen($value) > 1000) {
            throw new InvalidValueException("La descripción debe tener entre 20 y 1000 caracteres");
        }
    }
}
