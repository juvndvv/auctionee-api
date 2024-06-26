<?php

namespace App\Review\Infrastructure\Http\Controllers;

use App\Review\Application\Command\UpdateRating\UpdateRatingCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateRatingController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $rating = $request['rating'];

            $command = UpdateRatingCommand::create($uuid, $rating);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $rating,
                message: "Rating actualizado"
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación en el rating",
                error: $e->validator->getMessageBag()
            );

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);
    }
}
