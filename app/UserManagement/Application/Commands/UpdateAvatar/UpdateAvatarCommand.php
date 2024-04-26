<?php

namespace App\UserManagement\Application\Commands\UpdateAvatar;

use App\Shared\Application\Commands\Command;
use Illuminate\Http\UploadedFile;

class UpdateAvatarCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly UploadedFile $new
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function new(): UploadedFile
    {
        return $this->new;
    }

    public static function create(string $uuid, UploadedFile $new): self
    {
        return new self($uuid, $new);
    }
}
