<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\Command\UpdateRating\UpdateRatingCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Shared\Infraestructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateRatingController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request)
    {
        try {
            self::validate($request);

            $rating = $request['rating'];

            $command = UpdateRatingCommand::create($uuid, $rating);
            $this->commandBus->handle($command);

            return Response::OK($rating, "Rating actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el rating", $e->validator->getMessageBag());

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
