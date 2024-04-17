<?php

namespace App\Shared\Domain\Models\ValueObjects;

use InvalidArgumentException;

class ImageUrl
{
    public readonly int $value;

    public function __construct(int $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid($value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Url de imagen invalida");
        }
    }
}
