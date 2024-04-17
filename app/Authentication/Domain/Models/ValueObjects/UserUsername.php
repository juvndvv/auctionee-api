<?php

namespace App\Authentication\Domain\Models\ValueObjects;

final readonly class UserUsername
{
    private string $value;

    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(string $value): void
    {
        if (strlen($value) < 3) {
            throw new \InvalidArgumentException("El nombre de usuario debe tener al menos 3 caracteres");
        }

        if (strlen($value) > 32) {
            throw new \InvalidArgumentException("El nombre de usuario debe tener como máximo 32 caracteres");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

}
