<?php

namespace App\Auction\Domain\Models\Product;

class ProductEntity
{
    private ProductName $name;
    private ProductDescription $description;

    public function __construct(
        string $name,
        string $description,
    )
    {
        $this->name = new ProductName($name);
        $this->description = new ProductDescription($description);
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function description(): string
    {
        return $this->description->value();
    }

    public function updateName(string $name): void
    {
        $this->name = new ProductName($name);
    }

    public function updateDescription(string $description): void
    {
        $this->description = new ProductDescription($description);
    }
}
