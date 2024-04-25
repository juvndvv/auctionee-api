<?php

namespace App\UserManagement\Application\Commands\UpdateAvatar;

use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;
use App\Shared\Infraestructure\Bus\Events\EventBus;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class UpdateAvatarCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus               $eventBus,
        private readonly ImageRepositoryPort    $imageRepository,
        private readonly UserRepositoryPort     $userRepository
    )
    {}

    public function __invoke(UpdateAvatarCommand $command): string
    {
        $uuid = $command->uuid();
        $new = $command->new();

        // Search the user from the db
        $dbUser = $this->userRepository->findByUuid($uuid);

        if (is_null($dbUser)) {
            throw new ModelNotFoundException("El usuario con uuid $uuid no existe");
        }

        // Use case
        $user = User::fromPrimitives($dbUser->toArray());
        $old = $user->avatar();

        // Delete image if is not default
        if ($old !== env("DEFAULT_AVATAR")) {
            $this->imageRepository->delete($old);
        }

        // Save new avatar
        $newPath = $this->imageRepository->store("avatars", $new);
        $user->updateAvatar($newPath);
        $updates = $this->userRepository->updateAvatar($uuid, $newPath);

        if ($updates !== 1) {
            throw new RuntimeException('Ha ocurrido un error al intentar actualizar el avatar');
        }

        $this->eventBus->dispatch(...$user->pullDomainEvents());

        return $newPath;
    }
}
