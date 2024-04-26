<?php

namespace App\UserManagement\Application\Commands\Create;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(CreateUserCommand $command): void
    {
        $name = $command->name();
        $username = $command->username();
        $email = $command->email();
        $password = $command->password();
        $avatar = $command->avatar();
        $birth = $command->birth();
        $role = $command->role();

        $user = User::create(
            $name,
            $username,
            $email,
            $password,
            $avatar,
            $birth,
            $role
        );

        // Persists
        $this->userRepository->create($user->toPrimitives());

        // Publish events
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
