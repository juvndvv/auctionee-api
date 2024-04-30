<?php declare(strict_types=1);

namespace App\Auction\Domain\Models\Auction\ValueObjects;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;

final readonly class AuctionStartingDate
{
    private const string FORMAT = 'Y-m-d H:i:s';

    public function __construct(private string $value)
    {
        self::ensureIsValid($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function ensureIsValid(string $value): void
    {
        self::ensureFormatIsValid($value);
    }

    private static function ensureFormatIsValid(string $value): void
    {
        $date = DateTime::createFromFormat(self::FORMAT, $value);

        if (!$date && !$date->format(self::FORMAT) === $value) {
            throw new InvalidArgumentException("El formato de la fecha no es correcto: Y-m-d H:i:s");
        }
    }

    private static function ensureIsFuture(string $value): void
    {
        $date = DateTime::createFromFormat(self::FORMAT, $value);
        $today = DateTimeImmutable::createFromMutable(new DateTime());

        if ($date->getTimestamp() <= $today->getTimestamp()) {
            throw new InvalidArgumentException("La fecha ha de ser futura");
        }
    }
}
