<?php

namespace App\UserManagement\Application\UpdateAvatar;

use App\Shared\Domain\Bus\Command\Command;
use Illuminate\Http\UploadedFile;

class UpdateAvatarCommand extends Command
{
    public function __construct(private readonly string $uuid, private readonly UploadedFile $new)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function new(): UploadedFile
    {
        return $this->new;
    }
}
