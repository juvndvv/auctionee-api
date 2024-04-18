<?php

namespace App\Auction\Domain\Models\Product;

use App\Shared\Domain\Models\ValueObjects\TextValueObject;

class ProductDescription extends TextValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value, "ProductDescription");
    }
}
