<?php

namespace App\Auction\Domain\Models\Auction\ValueObjects;

enum Status
{
    case READY;
    case ONGOING;
    case COMPLETED;
}
