<?php

namespace App\UserManagement\Application\UpdateName;

use App\Shared\Infraestructure\Bus\Command\Command;

class UpdateNameCommand extends Command
{
    public function __construct(private readonly string $uuid, private readonly string $name)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }
}
