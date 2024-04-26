<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\Command\PlaceReview\PlaceReviewCommand;
use App\Shared\Infraestructure\Controllers\Response;
use App\Shared\Infraestructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class PlaceReviewBaseController extends ValidatedCommandController
{
    public function __invoke(Request $request)
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
