<?php declare(strict_types=1);

namespace App\Auction\Domain\Models\Category;

use App\Auction\Domain\Models\Category\ValueObjects\CategoryAvatar;
use App\Auction\Domain\Models\Category\ValueObjects\CategoryDescription;
use App\Auction\Domain\Models\Category\ValueObjects\CategoryName;
use App\Auction\Domain\Models\Category\ValueObjects\CategoryUuid;
use App\Shared\Domain\Models\AggregateRoot;

final class Category extends AggregateRoot
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_NAME = 'name';
    public const string SERIALIZED_DESCRIPTION = 'description';
    public const string SERIALIZED_AVATAR = 'avatar';

    private CategoryUuid $uuid;
    private CategoryName $name;
    private CategoryDescription $description;
    private CategoryAvatar $avatar;

    public function __construct(string $uuid, string $name, string $description, string $avatar)
    {
        $this->uuid = new CategoryUuid($uuid);
        $this->name = new CategoryName($name);
        $this->description = new CategoryDescription($description);
        $this->avatar = new CategoryAvatar($avatar);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function description(): string
    {
        return $this->description->value();
    }

    public function avatar(): string
    {
        return $this->avatar->value();
    }

    public function updateName(string $name)
    {
        $this->name = new CategoryName($name);
    }

    public function updateDescription(string $description)
    {
        $this->description = new CategoryDescription($description);
    }

    public function updateAvatar(string $avatar): void
    {
        $this->avatar = new CategoryAvatar($avatar);
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_NAME => $this->name(),
            self::SERIALIZED_DESCRIPTION => $this->description(),
            self::SERIALIZED_AVATAR => $this->avatar(),
        ];
    }

    public static function create(string $name, string $description, string $avatar): self
    {
        $uuid = CategoryUuid::random()->value();
        return new self($uuid, $name, $description, $avatar);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_NAME],
            $data[self::SERIALIZED_DESCRIPTION],
            $data[self::SERIALIZED_AVATAR]
        );
    }
}
