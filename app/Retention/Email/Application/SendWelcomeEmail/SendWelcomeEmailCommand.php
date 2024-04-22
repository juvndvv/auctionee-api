<?php

namespace App\Retention\Email\Application\SendWelcomeEmail;

use App\Shared\Domain\Bus\Command\Command;

class SendWelcomeEmailCommand extends Command
{
    public function __construct(private readonly string $to, private readonly string $name)
    {}

    public function to(): string
    {
        return $this->to;
    }

    public function name(): string
    {
        return $this->name;
    }
}
