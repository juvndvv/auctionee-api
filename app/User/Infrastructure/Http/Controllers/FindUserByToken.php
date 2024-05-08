<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Domain\Models\User;
use App\User\Domain\Projections\AuthenticatedUserProjection;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

final class FindUserByToken extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $request->validate(['token' => 'required']);

            $user = $request->user();

            return Response::OK(
                AuthenticatedUserProjection::create(
                    User::fromPrimitives($user->toArray()),
                    $request->input('token')
                ),
                'Token cambiado'
            );

        } catch (Exception $exception) {
            dd($exception);
        }
    }
}
