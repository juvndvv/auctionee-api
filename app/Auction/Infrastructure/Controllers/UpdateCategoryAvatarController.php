<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Controllers;

use App\Auction\Application\Commands\UpdateCategoryAvatar\UpdateCategoryAvatarCommand;
use App\Shared\Infrastructure\Controllers\Response;
use App\Shared\Infrastructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateCategoryAvatarController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $avatar = $request->file("avatar");

            $command = UpdateCategoryAvatarCommand::create($uuid, $avatar);
            $this->commandBus->handle($command);

            return Response::OK(null, "Avatar actualizado");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validacion", $e->validator->getMessageBag());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(["avatar" => "required|image|mimes:jpeg,jpg,png,gif"]);
    }
}
