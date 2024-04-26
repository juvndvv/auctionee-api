<?php

namespace App\User\Domain\Models\ValueObjects;

use InvalidArgumentException;

class UserRole
{
    const  USER = 0;
    const ADMIN = 1;
    const BLOCKED = 2;
    const DELETED = 3;

    public function __construct(private readonly int $value)
    {
        self::ensureIsValid($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private static function ensureIsValid(string $value): void
    {
        $valids = [0, 1, 2, 3];
        if (!in_array($value, $valids)) {
            throw new InvalidArgumentException("El valor del rol no es valido");
        }
    }
}
