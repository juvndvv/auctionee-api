<?php

namespace App\UserManagement\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\UserManagement\Application\Resources\UserSmallResource;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(private readonly UserRepositoryPort  $userRepository)
    {}

    public function __invoke(CreateUserCommand $command): array
    {
        $user = User::create(
            $command->name(),
            $command->username(),
            $command->email(),
            $command->password(),
            $command->avatar()
        );

        // Persists
        $userModel = $this->userRepository->create($user->toPrimitives());

        // TODO: publish event

        return UserSmallResource::fromArray($userModel->toArray());
    }
}
