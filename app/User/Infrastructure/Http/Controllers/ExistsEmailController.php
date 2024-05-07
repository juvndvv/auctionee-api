<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class ExistsEmailController extends ValidatedCommandController
{

    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $email = $request->input("email");

            $exists = EloquentUserModel::query()
                ->where("email", $email)
                ->exists();

            return Response::OK($exists, $exists ? 'El email ya existe' : 'El email no existe');

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY('Errores de validacion', $exception->validator->getMessageBag());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['email' => 'required|email']);
    }
}
