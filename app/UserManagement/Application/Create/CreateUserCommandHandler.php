<?php

namespace App\UserManagement\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(private readonly UserRepositoryPort  $userRepository)
    {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = User::create(
            $command->name(),
            $command->username(),
            $command->email(),
            $command->password(),
            $command->avatar(),
            $command->birth(),
            $command->role()
        );

        // Persists
        $userModel = $this->userRepository->create($user->toPrimitives());

        // TODO: publish event
    }
}
