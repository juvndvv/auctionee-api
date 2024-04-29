<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Controllers\Response;
use App\Shared\Infrastucture\Controllers\ValidatedCommandController;
use App\User\Application\Commands\Authenticate\AuthenticateCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class AuthenticateController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $email = $request->input('email');
            $password = $request->input('password');

            $command = AuthenticateCommand::create($email, $password);
            $resource = $this->commandBus->handle($command);

            return Response::OK($resource, "Autenticacion exitosa");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el usuario", $e->validator->getMessageBag());

        } catch (BadRequestException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
    }
}
