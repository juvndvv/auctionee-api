<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateAuctionDuration\UpdateAuctionDurationCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateAuctionDurationController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $duration = $request->input('duration');

            $command = UpdateAuctionDurationCommand::create($uuid, $duration);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $duration,
                message: "Duracion actualizada"
            );

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validacion",
                error: $exception->validator->getMessageBag()
            );

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['duration' => 'required|integer|min:1',]);
    }
}
