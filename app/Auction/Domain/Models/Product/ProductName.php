<?php

namespace App\Auction\Domain\Models\Product;

use App\Shared\Domain\Models\ValueObjects\StringValueObject;

class ProductName extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value, "ProductName");
    }
}
