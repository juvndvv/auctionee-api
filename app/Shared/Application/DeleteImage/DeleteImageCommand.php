<?php

namespace App\Shared\Application\DeleteImage;

use App\Shared\Infraestructure\Bus\Command\Command;

class DeleteImageCommand extends Command
{
    public function __construct(private readonly string $path)
    {}

    public function path(): string
    {
        return $this->path;
    }
}
