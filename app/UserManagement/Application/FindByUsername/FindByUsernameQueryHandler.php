<?php

namespace App\UserManagement\Application\FindByUsername;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindByUsernameQueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByUsernameQuery $query): Model
    {
        try {
            return $this->userRepository->findByUsername($query->username());

        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('Usuario ' . $query->username() . ' no encontrado');
        }
    }
}
