<?php

namespace App\Auction\Domain\Models\ValueObjects;

use http\Exception\InvalidArgumentException;

class AuctionDuration
{
    public readonly int $value;

    public function __construct(int $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid($value): void
    {
        if ($value % 5 !== 0)
        {
            throw new InvalidArgumentException("La duracion debe ser multiplo de 5");
        }
    }
}
