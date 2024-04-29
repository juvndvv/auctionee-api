<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Command\PlaceReview\PlaceReviewCommand;
use App\Shared\Infrastucture\Controllers\Response;
use App\Shared\Infrastucture\Controllers\ValidatedCommandController;
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

            $reviewerUuid = $request['reviewerUuid'];
            $reviewedUuid = $request['reviewedUuid'];
            $description = $request['description'];
            $rating = $request['rating'];

            $command = PlaceReviewCommand::create($reviewerUuid, $reviewedUuid, $description, $rating);
            $this->commandBus->handle($command);

            return Response::CREATED("Review creada satisfactoriamente", "/user/" . $reviewedUuid . "/reviews");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el usuario", $e->validator->getMessageBag());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'reviewerUuid' => 'required|string|exists:users,uuid',
            'reviewedUuid' => 'required|string|exists:users,uuid',
            'description' => 'required|string',
            'rating' => 'required|integer|between:1,5'
        ]);
    }
}
