<?php

namespace App\UserManagement\Application\UpdateAvatar;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use RuntimeException;

class UpdateAvatarCommandHandler extends CommandHandler
{
    public function __construct(private readonly ImageRepositoryPort $imageRepository, private readonly UserRepositoryPort  $userRepository)
    {}

    public function __invoke(UpdateAvatarCommand $command): string
    {
        $uuid = $command->uuid();
        $new = $command->new();

        // Search last avatar
        $old = $this->userRepository->findByUuid($uuid)->toArray()["avatar"];

        // Delete image if is not default
        if ($old !== env("DEFAULT_AVATAR")) {
            $this->imageRepository->delete($old);
        }

        // Save new avatar
        $newPath = $this->imageRepository->store("avatars", $new);
        $updates = $this->userRepository->updateAvatar($uuid, $newPath);

        if ($updates !== 1) {
            throw new RuntimeException('Update avatar failed');
        }

        return $newPath;
    }
}
