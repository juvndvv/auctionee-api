<?php

namespace App\Retention\Email\Application;

use App\Shared\Application\Commands\Command;

class SendEmailCommand extends Command
{
    private function __construct(
        private readonly string $to,
        private readonly string $name,
        private readonly string $type
    )
    {}

    public static function create(string $to, string $name, string $type): SendEmailCommand
    {
        return new self($to, $name, $type);
    }

    public function to(): string
    {
        return $this->to;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }
}
