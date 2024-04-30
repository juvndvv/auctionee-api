<?php declare(strict_types=1);

namespace App\Auction\Domain\Resources;

final class CategoryResource
{
    private function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public string $avatar,
    )
    {}

    public static function create(string $uuid, string $name, string $description, string $avatar): self
    {
        return new self($uuid, $name, $description, $avatar);
    }
}
