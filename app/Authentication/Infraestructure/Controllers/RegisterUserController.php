<?php

namespace App\Authentication\Infraestructure\Controllers;

use App\Authentication\Domain\Ports\Inbound\RegisterUserUseCasePort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController
{
    public function __construct(
        private readonly RegisterUserUseCasePort $registerUserUseCase
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        // Todo: validar

        $user = $this->registerUserUseCase->invoke($request->toArray());

        $token = $user->createToken('apiToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return new JsonResponse($response, 201);
    }
}
