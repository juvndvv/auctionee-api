<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\UserManagement\Domain\Ports\Inbound\CreateUserPort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController
{
    public function __construct(
        private readonly CreateUserPort $userCreator
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->userCreator->__invoke($request->toArray());
        return new JsonResponse($user, Response::HTTP_CREATED);
    }
}
