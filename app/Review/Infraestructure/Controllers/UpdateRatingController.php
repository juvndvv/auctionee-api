<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\Command\UpdateRating\UpdateRatingCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateRatingController extends CommandController
{
    public function __invoke(string $uuid, Request $request)
    {
        try {
            self::validate($request);

            $rating = $request['rating'];

            $command = new UpdateRatingCommand($uuid, $rating);
            $this->commandBus->handle($command);

            return Response::OK($rating, "Rating actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el rating", $e->validator->getMessageBag());

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);
    }
}
