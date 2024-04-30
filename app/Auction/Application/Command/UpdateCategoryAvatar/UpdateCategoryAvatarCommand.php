<?php

namespace App\Auction\Application\Command\UpdateCategoryAvatar;

use App\Shared\Application\Commands\Command;
use Illuminate\Http\UploadedFile;

final class UpdateCategoryAvatarCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly UploadedFile $avatar
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function avatar(): UploadedFile
    {
        return $this->avatar;
    }

    public static function create(string $uuid, UploadedFile $avatar): self
    {
        return new self($uuid, $avatar);
    }
}
