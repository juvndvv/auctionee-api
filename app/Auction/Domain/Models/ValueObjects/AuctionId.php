<?php

namespace App\Auction\Domain\Models\ValueObjects;

class AuctionId
{
    public readonly int $value;

    public function __construct(int $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid($value): void
    {
        // TODO: implementar
    }
}
