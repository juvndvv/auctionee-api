<?php

namespace App\UserManagement\Application\UpdateAvatar;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class UpdateAvatarCommandHandler extends CommandHandler
{
    public function __construct(private readonly ImageRepositoryPort $imageRepository, private readonly UserRepositoryPort  $userRepository)
    {}

    public function __invoke(UpdateAvatarCommand $command): string
    {
        $uuid = $command->uuid();
        $new = $command->new();

        // Search the user and get the avatar
        $user = $this->userRepository->findByUuid($uuid);

        if (is_null($user)) {
            throw new ModelNotFoundException("El usuario con uuid $uuid no existe");
        }

        $old = $user->toArray()['avatar'];

        // Delete image if is not default
        if ($old !== env("DEFAULT_AVATAR")) {
            $this->imageRepository->delete($old);
        }

        // Save new avatar
        $newPath = $this->imageRepository->store("avatars", $new);
        $updates = $this->userRepository->updateAvatar($uuid, $newPath);

        if ($updates !== 1) {
            throw new RuntimeException('Ha ocurrido un error al intentar actualizar el avatar');
        }

        return $newPath;
    }
}
