<?php

namespace App\Authentication\Domain\Models\ValueObjects;

use DateTime;

class UserBirthDate
{
    private readonly DateTime $value;

    public function __construct(DateTime $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(DateTime $value): void
    {
        if ($value->getTimestamp() > time()) {
            throw new \InvalidArgumentException("La fecha debe ser una fecha inferior a la fecha actual");
        }
    }

    public function value(): DateTime
    {
        return $this->value;
    }
}
