<?php declare(strict_types=1);

namespace App\Auction\Application\Command\UpdateCategoryDescription;

use App\Shared\Application\Commands\Command;

final class UpdateCategoryDescriptionCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $description,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function description(): string
    {
        return $this->description;
    }

    public static function create(string $uuid, string $description): UpdateCategoryDescriptionCommand
    {
        return new self($uuid, $description);
    }
}
