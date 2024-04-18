<?php

namespace App\Shared\Domain\Models\ValueObjects;

use App\Authentication\Domain\Models\ValueObjects\UserEmail;

abstract class EmailValueObject
{
    private readonly string $value;

    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El email no es valido");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EmailValueObject $emailValueObject): bool
    {
        return $this->value === $emailValueObject->value;
    }
}
