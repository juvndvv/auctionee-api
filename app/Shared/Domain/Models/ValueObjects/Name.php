<?php

namespace App\Shared\Domain\Models\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidValueException;

final class Name
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
        if (strlen($value) < 1 || strlen($value) > 255) {
            throw new InvalidValueException("Name must be between 1 and 255 characters.");
        }
    }
}
