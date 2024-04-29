<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Infrastucture\Controllers\Response;
use App\Shared\Infrastucture\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdateAvatar\UpdateAvatarCommand;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UpdateUserAvatarController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $avatar = $request->file("avatar");

            $command = UpdateAvatarCommand::create($uuid, $avatar);
            $newPath = $this->commandBus->handle($command);

            return Response::OK($newPath, "Avatar actualizado correctamente");

        } catch (ModelNotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            "avatar" => "required|image|mimes:jpeg,png,jpg,webp|max:2048"
        ]);
    }
}
