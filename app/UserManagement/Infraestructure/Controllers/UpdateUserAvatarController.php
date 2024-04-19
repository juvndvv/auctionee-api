<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\UpdateAvatar\UpdateAvatarCommand;
use Exception;
use Illuminate\Http\Request;

class UpdateUserAvatarController extends Controller
{
    public function __construct(private readonly CommandBus  $commandBus)
    {}

    public function __invoke(string $uuid, Request $request)
    {
        try {
            self::validate($request);

            $avatar = $request->file("avatar");

            $command = new UpdateAvatarCommand($uuid, $avatar);
            $newPath = $this->commandBus->handle($command);

            return Response::OK($newPath, "Avatar actualizado correctamente");

        } catch (Exception $e) {
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
