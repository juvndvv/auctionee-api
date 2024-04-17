<?php

namespace App\Authentication\Domain\Models\ValueObjects;

use Illuminate\Support\Facades\Date;

final readonly class UserBirthDate
{
    private readonly Date $value;

    public function __construct(Date $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(Date $value): void
    {
        if ($value < Date::now()) {
            throw new \InvalidArgumentException("La fecha debe ser una fecha inferior a la fecha actual");
        }
    }

    public function value(): Date
    {
        return $this->value;
    }
}
