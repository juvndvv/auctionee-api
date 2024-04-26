<?php

namespace App\Retention\Email\Domain\Model;

class Email
{
    public const WELCOME = 'welcome';
    public const UPDATED = 'updated';
    public const BLOCKED = 'blocked';
    public const UNBLOCKED = 'unblocked';
    public const DELETED = 'deleted';

    public function __construct(
        private readonly string $from,
        private readonly string $to,
        private readonly string $content,
        private readonly string $subject,
    )
    {}

    public function to(): string
    {
        return $this->to;
    }

    public function from(): string
    {
        return $this->from;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function subject(): string
    {
        return $this->subject;
    }
}
