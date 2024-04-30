<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\CreateCategory;

use App\Shared\Application\Commands\Command;

final class CreateCategoryCommand extends Command
{
    private function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $avatar,
    )
    {}

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function avatar(): string
    {
        return $this->avatar;
    }

    public static function create(string $name, string $description, string $avatar): CreateCategoryCommand
    {
        return new self($name, $description, $avatar);
    }
}
