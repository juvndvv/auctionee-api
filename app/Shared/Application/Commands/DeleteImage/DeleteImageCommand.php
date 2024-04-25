<?php

namespace App\Shared\Application\Commands\DeleteImage;

use App\Shared\Application\Commands\Command;

class DeleteImageCommand extends Command
{
    private function __construct(private readonly string $path)
    {}

    public function path(): string
    {
        return $this->path;
    }
}
