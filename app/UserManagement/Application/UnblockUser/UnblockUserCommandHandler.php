<?php

namespace App\UserManagement\Application\UnblockUser;

use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class UnblockUserCommandHandler
{
    public function __construct(private UserRepositoryPort $userRepository)
    {
    }

    public function __invoke(UnblockUserCommand $command)
    {
        $uuid = $command->uuid();
        $this->userRepository->unblock($uuid);
    }
}
