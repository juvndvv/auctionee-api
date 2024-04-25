<?php

namespace App\Retention\Email\Application;

use App\Shared\Infraestructure\Bus\Command\Command;

class SendEmailCommand extends Command
{
    public function __construct(private readonly string $to, private readonly string $name, private readonly string $type)
    {}

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
