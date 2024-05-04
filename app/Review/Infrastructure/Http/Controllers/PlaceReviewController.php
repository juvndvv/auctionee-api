<?php

namespace App\Review\Infrastructure\Http\Controllers;

use App\Review\Application\Command\PlaceReview\PlaceReviewCommand;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class PlaceReviewController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $reviewerUuid = $request->user()->uuid;
            $reviewedUuid = $request['reviewedUuid'];
            $description = $request['description'];
            $rating = $request['rating'];

            $command = PlaceReviewCommand::create($reviewerUuid, $reviewedUuid, $description, $rating);
            $this->commandBus->handle($command);

            return Response::CREATED(
                message: "Review creada",
                url: "/user/" . $reviewedUuid . "/reviews"
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación en el usuario",
                error: $e->validator->getMessageBag()
            );

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'reviewedUuid' => 'required|string|exists:users,uuid',
            'description' => 'required|string',
            'rating' => 'required|integer|between:1,5'
        ]);
    }
}
