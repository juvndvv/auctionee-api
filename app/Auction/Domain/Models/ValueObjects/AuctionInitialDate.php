<?php

declare(strict_types=1);

namespace App\Auction\Domain\Models\ValueObjects;

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
        // TODO: implementar validaciones
    }
}
