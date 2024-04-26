<?php

namespace App\Social\Domain\Models;

use App\Social\Domain\Models\ValueObjects\MessageContent;
use App\Social\Domain\Models\ValueObjects\MessageUuid;
use App\User\Domain\Models\ValueObjects\UserId;

class Message
{
    private MessageUuid $messageUuid;
    private UserId $senderUuid;
    private MessageContent $content;

    public function __construct(string $uuid, string $senderUuid, string $content)
    {
        $this->messageUuid = new MessageUuid($uuid);
        $this->senderUuid = new UserId($senderUuid);
        $this->content = new MessageContent($content);
    }

    public function messageUuid(): string
    {
        return $this->messageUuid->value();
    }

    public function senderUuid(): string
    {
        return $this->senderUuid->value();
    }

    public function content(): string
    {
        return $this->content->value();
    }

    public static function fromPrimitives(array $data): self
    {

        return new self(
            $data['uuid'],
            $data['sender_uuid'],
            $data['content']
        );
    }

    public function toPrimitives(string $chatRoomUuid): array
    {
        return [
            'uuid' => $this->messageUuid(),
            'chat_room_uuid' => $chatRoomUuid,
            'sender_uuid' => $this->senderUuid(),
            'content' => $this->content()
        ];
    }

    public static function create(string $senderUuid, string $content): self
    {
        $uuid = MessageUuid::random();
        return new self($uuid, $senderUuid, $content);
    }

    public function delete(): void
    {
    }
}
