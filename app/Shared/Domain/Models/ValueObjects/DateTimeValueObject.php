<?php

namespace App\Shared\Domain\Models\ValueObjects;

use DateTime;
use InvalidArgumentException;

abstract class DateTimeValueObject
{
    public function __construct(private readonly string $value, private readonly string $format = 'Y-m-d H:i:s' )
    {
        self::ensureIsValid($value, $format);
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function ensureIsValid(string $date, string $format): void
    {
        if (!DateTime::createFromFormat($format, $date)) {
            throw new InvalidArgumentException("El formato de la fecha no es correcto");
        }
    }
}
