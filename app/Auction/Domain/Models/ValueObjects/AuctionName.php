<?php

namespace App\Auction\Domain\Models\ValueObjects;

use InvalidArgumentException;

class AuctionName
{
    public readonly string $value;

    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid($value): void
    {
        if (strlen($value) < 3 || strlen($value) > 64) {
            throw new InvalidArgumentException();
        }
    }
}
