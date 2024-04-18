<?php

namespace App\Authentication\Application;

use App\Authentication\Domain\Models\User;
use App\Authentication\Domain\Ports\Inbound\RegisterUserUseCasePort;
use App\Authentication\Domain\Ports\Outbound\AuthRepositoryPort;
use App\Authentication\Infraestructure\Repositories\Models\EloquentUserModel;
use App\Shared\Domain\Models\ValueObjects\Uuid;

class RegisterUserUseCase implements RegisterUserUseCasePort
{
    public function __construct(
        private readonly AuthRepositoryPort $authRepository
    )
    {}

    public function invoke(array $data): EloquentUserModel
    {
        $data['id'] = Uuid::random();
        $user = User::create($data);
        return $this->authRepository->register($user->toArray());
    }
}
