<?php declare(strict_types=1);

namespace App\Auction\Domain\Models\Auction\ValueObjects;

use InvalidArgumentException;

final readonly class AuctionStatus
{
    public function __construct(private string $value)
    {
        self::ensureIsValid($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private static function ensureIsValid(string $value): void
    {
        if ($value != Status::READY->name && $value != Status::ONGOING->name && $value != Status::COMPLETED->name) {
            throw new InvalidArgumentException("Estado inválido: $value");
        }
    }
}
