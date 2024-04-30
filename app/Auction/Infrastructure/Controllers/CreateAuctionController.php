<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Controllers;

use App\Auction\Application\Commands\CreateAuction\CreateAuctionCommand;
use App\Shared\Infrastructure\Controllers\Response;
use App\Shared\Infrastructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class CreateAuctionController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $categoryUuid = $request->input('category_uuid');
            $userUuid = $request->input('user_uuid');
            $name = $request->input('name');
            $description = $request->input('description');
            $status = $request->input('status');
            $startingPrice = $request->float('starting_price');
            $startingDate = $request->input('starting_date');
            $duration = $request->integer('duration');

            $command = CreateAuctionCommand::create($categoryUuid, $userUuid, $name, $description, $status, $startingPrice, $startingDate, $duration);
            $uuid = $this->commandBus->handle($command);

            return Response::CREATED("Subasta creada con exito", "/auctions/" .  $uuid);

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validacion", $exception->validator->getMessageBag());

        } catch (Exception $exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
