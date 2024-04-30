<?php declare(strict_types=1);

namespace App\Auction\Domain\Models\Auction;

use App\Auction\Domain\Events\AuctionPlacedEvent;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionDescription;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionDuration;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionName;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStartingDate;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStartingPrice;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStatus;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionUuid;
use App\Auction\Domain\Models\Category\ValueObjects\CategoryUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserId;

final class Auction extends AggregateRoot
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_CATEGORY_UUID = 'category_uuid';
    public const string SERIALIZED_USER_UUID = 'user_uuid';
    public const string SERIALIZED_NAME = 'name';
    public const string SERIALIZED_DESCRIPTION = 'description';
    public const string SERIALIZED_STATUS = 'status';
    public const string SERIALIZED_STARTING_PRICE = 'starting_price';
    public const string SERIALIZED_STARTING_DATE = 'starting_date';
    public const string SERIALIZED_DURATION = 'duration';

    private AuctionUuid $uuid;
    private CategoryUuid $categoryUuid;
    private UserId $userUuid;
    private AuctionName $name;
    private AuctionDescription $description;
    private AuctionStatus $status;
    private AuctionStartingPrice $startingPrice;
    private AuctionStartingDate $startingDate;
    private AuctionDuration $duration;

    public function __construct(
        string $uuid,
        string $categoryUuid,
        string $userUuid,
        string $name,
        string $description,
        string $status,
        float $startingPrice,
        string $startingDate,
        int $duration,
    )
    {
        $this->uuid = new AuctionUuid($uuid);
        $this->categoryUuid = new CategoryUuid($categoryUuid);
        $this->userUuid = new UserId($userUuid);
        $this->name = new AuctionName($name);
        $this->description = new AuctionDescription($description);
        $this->status = new AuctionStatus($status);
        $this->startingPrice = new AuctionStartingPrice($startingPrice);
        $this->startingDate = new AuctionStartingDate($startingDate);
        $this->duration = new AuctionDuration($duration);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function categoryUuid(): string
    {
        return $this->categoryUuid->value();
    }

    public function userUuid(): string
    {
        return $this->userUuid->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function description(): string
    {
        return $this->description->value();
    }

    public function status(): string
    {
        return $this->status->value();
    }

    public function startingPrice(): float
    {
        return $this->startingPrice->value();
    }

    public function startingDate(): string
    {
        return $this->startingDate->value();
    }

    public function duration(): int
    {
        return $this->duration->value();
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid->value(),
            self::SERIALIZED_CATEGORY_UUID => $this->categoryUuid->value(),
            self::SERIALIZED_USER_UUID => $this->userUuid->value(),
            self::SERIALIZED_NAME => $this->name->value(),
            self::SERIALIZED_DESCRIPTION => $this->description->value(),
            self::SERIALIZED_STATUS => $this->status->value(),
            self::SERIALIZED_STARTING_PRICE => $this->startingPrice->value(),
            self::SERIALIZED_STARTING_DATE => $this->startingDate->value(),
            self::SERIALIZED_DURATION => $this->duration->value(),
        ];
    }


    public static function create(
        string $categoryUuid,
        string $userUuid,
        string $name,
        string $description,
        string $status,
        float $startingPrice,
        string $startingDate,
        int $duration,
    ): self
    {
        $uuid = AuctionUuid::random()->value();

        $auction = new self(
            $uuid,
            $categoryUuid,
            $userUuid,
            $name,
            $description,
            $status,
            $startingPrice,
            $startingDate,
            $duration
        );

        $auction->record(new AuctionPlacedEvent(now()->toString(), $auction->toPrimitives()));

        return $auction;
    }
}
