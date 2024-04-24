<?php

namespace App\Social\Domain\Models;

use App\Social\Domain\Models\ValueObjects\MessageContent;
use App\UserManagement\Domain\Models\ValueObjects\UserId;

class Message
{
    private UserId $senderUuid;
    private MessageContent $content;

    public function __construct(string $senderUuid, string $content)
    {
        $this->senderUuid = new UserId($senderUuid);
        $this->content = new MessageContent($content);
    }

    public function senderUuid(): string
    {
        return $this->senderUuid->value();
    }

    public function content(): string
    {
        return $this->content->value();
    }

    public function toPrimitives(): array
    {
        return [
            'user_uuid' => $this->senderUuid(),
            'content' => $this->content()
        ];
    }

    public static function create(string $senderUuid, string $content): self
    {
        return new self($senderUuid, $content);
    }
}
