<?php

namespace App\Auction\Domain\Models\ValueObjects;

use InvalidArgumentException;

class AuctionDescription
{
    public readonly string $value;

    public function __construct(string $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid($value): void
    {
        if (strlen($value) < 20 || strlen($value) > 1000) {
            throw new InvalidArgumentException();
        }
    }
}
