<?php

namespace App\UserManagement\Application\FindById;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindByIdQueryHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(FindByIdQuery $query): Model
    {
        try {
            return $this->userRepository->findById($query->id());

        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('Usuario no encontrado');
        }
    }
}
