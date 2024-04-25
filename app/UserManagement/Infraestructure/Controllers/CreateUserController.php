<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Application\UploadImage\UploadImageCommand;
use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\Create\CreateUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

readonly class CreateUserController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $name = $request->input('name');
            $username = $request->input('username');
            $email = $request->input('email');
            $password = $request->input('password');
            $avatar = $request->file('avatar');
            $birth = $request->input('birth');

            // Upload the image
            if ($avatar) {
                $avatarCommand = new UploadImageCommand("avatars", $avatar);
                $avatar = $this->commandBus->handle($avatarCommand);

            } else {
                $avatar = env('DEFAULT_AVATAR');
            }

            // Create the user
            $command = new CreateUserCommand($name, $username, $email, $password, $avatar, $birth, 0);
            $resource = $this->commandBus->handle($command);

            return Response::CREATED("Usuario creado satisfactoriamente", "/users/" . $username);

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el usuario", $e->validator->getMessageBag());

        } catch (Exception $e) {
            dd($e);
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
            'avatar' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'birth' => 'required|date',
        ]);
    }
}
