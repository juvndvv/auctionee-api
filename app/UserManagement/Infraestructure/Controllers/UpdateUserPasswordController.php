<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\UpdateName\UpdateNameCommand;
use App\UserManagement\Application\UpdatePassword\UpdatePasswordCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateUserPasswordController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $password = $request["password"];

            $command = new UpdatePasswordCommand($uuid, $password);
            $this->commandBus->handle($command);

            return Response::OK($password, "Contraseña actualizada correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en la contraseña", $e->validator->getMessageBag());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'password' => 'required|string|max:255',
        ]);
    }
}
