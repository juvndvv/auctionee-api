<?php

namespace App\Retention\Email\Application;

use App\Shared\Application\Command;

class SendEmailCommand extends Command
{
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
