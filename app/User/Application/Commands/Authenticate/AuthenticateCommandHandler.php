<?php

namespace App\User\Application\Commands\Authenticate;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Domain\Projections\AuthenticatedUserProjection;

final class AuthenticateCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function __invoke(AuthenticateCommand $command): AuthenticatedUserProjection
    {
        $email = $command->email();
        $password = $command->password();

        $token = $this->userRepository->authenticate($email, $password);
        $user = $this->userRepository->findByEmail($email);

        return AuthenticatedUserProjection::create($user, $token);
    }
}
