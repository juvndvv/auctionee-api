<?php

namespace App\Social\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\Social\Domain\Events\FriendRequestCreatedEvent;
use App\Social\Domain\Models\ValueObjects\FriendRequestUuid;
use App\User\Domain\Models\ValueObjects\UserId;

class FriendRequest extends AggregateRoot
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_SENDER_UUID = 'sender_uuid';
    public const string SERIALIZED_RECEIVER_UUID = 'receiver_uuid';

    private readonly FriendRequestUuid $uuid;
    private readonly UserId $sender;
    private readonly UserId $receiver;

    public function __construct(string $uuid, string $sender, string $receiver)
    {
        $this->uuid = new FriendRequestUuid($uuid);
        $this->sender = new UserId($sender);
        $this->receiver = new UserId($receiver);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function senderUuid(): string
    {
        return $this->sender->value();
    }

    public function receiverUuid(): string
    {
        return $this->receiver->value();
    }

    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_SENDER_UUID => $this->senderUuid(),
            self::SERIALIZED_RECEIVER_UUID => $this->receiverUuid(),
        ];
    }

    public static function create(string $uuid, string $sender, string $receiver): self
    {
        $friendRequest = new FriendRequest($uuid, $sender, $receiver);
        $friendRequest->record(new FriendRequestCreatedEvent($friendRequest->toPrimitives(), now()->toString()));

        return $friendRequest;
    }
}
