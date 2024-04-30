<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\CreateAuction;

use App\Shared\Application\Commands\Command;

final class CreateAuctionCommand extends Command
{
    private function __construct(
        private readonly string $categoryUuid,
        private readonly string $userUuid,
        private readonly string $name,
        private readonly string $description,
        private readonly string $status,
        private readonly float  $startingPrice,
        private readonly string $startingDate,
        private readonly int    $duration
    )
    {}

    public function categoryUuid(): string
    {
        return $this->categoryUuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function startingPrice(): float
    {
        return $this->startingPrice;
    }

    public function startingDate(): string
    {
        return $this->startingDate;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public static function create(
        string $categoryUuid,
        string $userUuid,
        string $name,
        string $description,
        string $status,
        float $startingPrice,
        string $startingDate,
        int $duration
    ): self
    {
        return new self(
            $categoryUuid,
            $userUuid,
            $name,
            $description,
            $status,
            $startingPrice,
            $startingDate,
            $duration
        );
    }
}
