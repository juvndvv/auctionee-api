<?php

namespace App\UserManagement\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(private readonly UserRepositoryPort  $userRepository)
    {}

    public function __invoke(CreateUserCommand $command): User
    {
        $user = User::create(
            $command->name(),
            $command->username(),
            $command->email(),
            $command->password()
        );

        // Persists
        $this->userRepository->create($user->toPrimitives());

        // Publish event
        // TODO: publish event

        return $user;
    }
}
