<?php

namespace App\Auction\Domain\Models;

use DateTime;

class AuctionInitialDate
{
    public readonly DateTime $value;

    public function __construct(DateTime $value)
    {
        self::ensureIsValid($value);
        $this->value = $value;
    }

    public static function ensureIsValid(DateTime $value): void
    {

    }
}
