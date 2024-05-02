<?php declare(strict_types=1);

namespace App\Auction\Domain\Models\Auction;

use App\Auction\Domain\Events\AuctionPlacedEvent;
use App\Auction\Domain\Events\AuctionUpdatedEvent;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionAvatar;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionDescription;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionDuration;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionName;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStartingDate;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStartingPrice;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionStatus;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionUuid;
use App\Auction\Domain\Models\Category\ValueObjects\CategoryUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserUuid;

final class Auction extends AggregateRoot
{
    public const string UUID = 'uuid';
    public const string CATEGORY_UUID = 'category_uuid';
    public const string USER_UUID = 'user_uuid';
    public const string NAME = 'name';
    public const string DESCRIPTION = 'description';
    public const string STATUS = 'status';
    public const string STARTING_PRICE = 'starting_price';
    public const string STARTING_DATE = 'starting_date';
    public const string DURATION = 'duration';
    public const string AVATAR = 'avatar';

    private AuctionUuid $uuid;
    private CategoryUuid $categoryUuid;
    private UserUuid $userUuid;
    private AuctionName $name;
    private AuctionDescription $description;
    private AuctionStatus $status;
    private AuctionStartingPrice $startingPrice;
    private AuctionStartingDate $startingDate;
    private AuctionDuration $duration;
    private AuctionAvatar $avatar;

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
        string $avatar
    )
    {
        $this->uuid = new AuctionUuid($uuid);
        $this->categoryUuid = new CategoryUuid($categoryUuid);
        $this->userUuid = new UserUuid($userUuid);
        $this->name = new AuctionName($name);
        $this->description = new AuctionDescription($description);
        $this->status = new AuctionStatus($status);
        $this->startingPrice = new AuctionStartingPrice($startingPrice);
        $this->startingDate = new AuctionStartingDate($startingDate);
        $this->duration = new AuctionDuration($duration);
        $this->avatar = new AuctionAvatar($avatar);
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

    public function avatar(): string
    {
        return $this->avatar->value();
    }

    public function toPrimitives(): array
    {
        return [
            self::UUID => $this->uuid->value(),
            self::CATEGORY_UUID => $this->categoryUuid->value(),
            self::USER_UUID => $this->userUuid->value(),
            self::NAME => $this->name->value(),
            self::DESCRIPTION => $this->description->value(),
            self::STATUS => $this->status->value(),
            self::STARTING_PRICE => $this->startingPrice->value(),
            self::STARTING_DATE => $this->startingDate->value(),
            self::DURATION => $this->duration->value(),
            self::AVATAR => $this->avatar->value(),
        ];
    }

    public function updateCategoryUuid(string $categoryUuid): void
    {
        $old  = $this->categoryUuid();
        $this->categoryUuid = new CategoryUuid($categoryUuid);

        $changes = [
            'field' => self::CATEGORY_UUID,
            'old' => $old,
            'new' => $categoryUuid,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateName(string $name): void
    {
        $old  = $this->name();
        $this->name = new AuctionName($name);

        $changes = [
            'field' => self::NAME,
            'old' => $old,
            'new' => $name,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateDescription(string $description): void
    {
        $old  = $this->description();
        $this->description = new AuctionDescription($description);

        $changes = [
            'field' => self::DESCRIPTION,
            'old' => $old,
            'new' => $description,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateStartingPrice(float $startingPrice): void
    {
        $old  = $this->startingPrice();
        $this->startingPrice = new AuctionStartingPrice($startingPrice);

        $changes = [
            'field' => self::STARTING_PRICE,
            'old' => $old,
            'new' => $startingPrice,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateStartingDate(string $startingDate): void
    {
        $old  = $this->startingDate();
        $this->startingDate = new AuctionStartingDate($startingDate);

        $changes = [
            'field' => self::STARTING_DATE,
            'old' => $old,
            'new' => $startingDate,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateDuration(int $duration): void
    {
        $old  = $this->duration();
        $this->duration = new AuctionDuration($duration);

        $changes = [
            'field' => self::DURATION,
            'old' => $old,
            'new' => $duration,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
    }

    public function updateAvatar(string $avatar): void
    {
        $old = $this->avatar();
        $this->avatar = new AuctionAvatar($avatar);

        $changes = [
            'field' => self::AVATAR,
            'old' => $old,
            'new' => $avatar,
        ];

        $this->record(new AuctionUpdatedEvent($this->userUuid(), now()->toString(), $changes));
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
        string $avatar
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
            $duration,
            $avatar
        );

        $auction->record(new AuctionPlacedEvent($userUuid, now()->toString(), $auction->toPrimitives()));

        return $auction;
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::UUID],
            $data[self::CATEGORY_UUID],
            $data[self::USER_UUID],
            $data[self::NAME],
            $data[self::DESCRIPTION],
            $data[self::STATUS],
            $data[self::STARTING_PRICE],
            $data[self::STARTING_DATE],
            $data[self::DURATION],
            $data[self::AVATAR],
        );
    }
}
