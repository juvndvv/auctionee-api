<?php

namespace App\Auction\Domain\Models;

use InvalidArgumentException;

class AuctionPrice
{
    public readonly float $value;

    public function __construct(float $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("El valor ha de ser positivo");
        }
    }
}
