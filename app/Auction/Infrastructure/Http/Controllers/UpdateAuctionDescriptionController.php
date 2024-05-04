<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateAuctionDescription\UpdateAuctionDescriptionCommand;
use App\Auction\Application\Commands\UpdateAuctionName\UpdateAuctionNameCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateAuctionDescriptionController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $description = $request->input('description');

            $command = UpdateAuctionDescriptionCommand::create($uuid, $description);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $description,
                message: "Descripcion actualizada"
            );

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validacion",
                error: $exception->validator->getMessageBag()
            );

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND(
                message: $exception->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['description' => 'required|string']);
    }
}
