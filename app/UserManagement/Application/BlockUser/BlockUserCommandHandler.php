<?php

namespace App\UserManagement\Application\BlockUser;

use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class BlockUserCommandHandler
{
    public function __construct(private UserRepositoryPort $userRepository)
    {
    }

    public function __invoke(BlockUserCommand $command)
    {
        $uuid = $command->uuid();
        $this->userRepository->block($uuid);
    }
}
