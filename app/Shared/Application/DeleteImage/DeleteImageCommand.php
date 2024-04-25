<?php

namespace App\Shared\Application\DeleteImage;

use App\Shared\Application\Command;

class DeleteImageCommand extends Command
{
    private function __construct(private readonly string $path)
    {}

    public function path(): string
    {
        return $this->path;
    }
}
