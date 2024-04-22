<?php

namespace App\Retention\Email\Domain\Model;

class Email
{
    public function __construct(private readonly string $to, private readonly string $content)
    {}

    public function to(): string
    {
        return $this->to;
    }

    public function content(): string
    {
        return $this->content;
    }
}
