<?php

namespace App\Authentication\Infraestructure\Controllers;

use App\Authentication\Domain\Ports\Inbound\RegisterUserUseCasePort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterUserController
{
    public function __construct(
        private readonly RegisterUserUseCasePort $registerUserUseCase
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->registerUserUseCase->invoke($request->toArray());
        return new JsonResponse($user, Response::HTTP_CREATED);
    }
}
