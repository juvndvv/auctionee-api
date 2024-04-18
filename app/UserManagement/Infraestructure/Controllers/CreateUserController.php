<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Responses\Response;
use App\UserManagement\Application\Create\CreateUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateUserController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        self::validate($request);

        $name = $request->input('name');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        $command = new CreateUserCommand($name, $username, $email, $password);

        try {
            $this->commandBus->handle($command);
            return Response::CREATED("Usuario creado satisfactoriamente", "/users/" . $username);

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
    }
}
