<?php

namespace App\Authentication\Application;

use App\Authentication\Domain\Ports\Inbound\RegisterUserUseCasePort;
use App\Authentication\Domain\Ports\Outbound\AuthRepositoryPort;
use App\Authentication\Infraestructure\Repositories\Models\EloquentUserModel;

class RegisterUserUseCase implements RegisterUserUseCasePort
{
    public function __construct(
        private readonly AuthRepositoryPort $authRepository
    )
    {}

    public function invoke(array $data): EloquentUserModel
    {
        return $this->authRepository->register($data);
    }
}
