<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

final class LogoutController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            PersonalAccessToken::findToken($request->bearerToken())->delete();

            return Response::OK('', 'Sesion cerrada');

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
