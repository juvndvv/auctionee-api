<?php

namespace App\Social\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\Social\Domain\Events\FriendshipCreatedEvent;
use App\Social\Domain\Events\FriendshipDeletedEvent;
use App\Social\Domain\Models\ValueObjects\FriendshipUuid;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use Illuminate\Queue\SerializesModels;

class Friendship extends AggregateRoot
{
    public const SERIALIZED_UUID = 'uuid';
    public const SERIALIZED_LEFT_UUID = 'left_uuid';
    public const SERIALIZED_RIGHT_UUID = 'right_uuid';

    private FriendshipUuid $uuid;
    private UserId $left;
    private UserId $right;

    /**
     * @param string $uuid
     * @param string $leftUuid
     * @param string $rightUuid
     */
    private function __construct(string $uuid, string $leftUuid, string $rightUuid)
    {
        $this->uuid = new FriendshipUuid($uuid);
        $this->left = new UserId($leftUuid);
        $this->right = new UserId($rightUuid);
    }

    /**
     * Devuelve el valor del uuid
     *
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid->value();
    }

    /**
     * Devuelve el valor del uuid del usuario <i>left</i>
     *
     * @return string
     */
    public function left(): string
    {
        return $this->left->value();
    }

    /**
     * Devuelve el valor del uuid del usuario <i>right</i>
     *
     * @return string
     */
    public function right(): string
    {
        return $this->right->value();
    }

    /**
     * Serializa el objeto
     *
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_LEFT_UUID => $this->left(),
            self::SERIALIZED_RIGHT_UUID => $this->right()
        ];
    }

    /**
     * Deserializa el objeto
     *
     * @param array $data
     * @return Friendship
     */
    public static function fromPrimitives(array $data): Friendship
    {
        return new Friendship(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_LEFT_UUID],
            $data[self::SERIALIZED_RIGHT_UUID]
        );
    }

    /**
     * Crea una instancia de la clase y genera el evento
     *
     * @param string $leftUuid
     * @param string $rightUuid
     * @return self
     */
    public static function create(string $leftUuid, string $rightUuid): self
    {
        // Genera el id y crea Friendship
        $uuid = FriendshipUuid::random();
        $friendship = new self($uuid, $leftUuid, $rightUuid);

        // Genera evento
        $friendship->record(FriendshipCreatedEvent::create($friendship->toPrimitives(), now()->toString()));

        return $friendship;
    }

    public function delete(): void
    {
        $this->record(FriendshipDeletedEvent::create($this->toPrimitives(), now()->toString()));
    }
}
