<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Infrastucture\Controllers\CommandController;
use App\Shared\Infrastucture\Controllers\Response;
use App\Social\Application\Commands\CreateChatRoom\CreateChatRoomCommand;
use Exception;
use Illuminate\Http\Request;

final class CreateChatRoomBaseController extends CommandController
{
    public function __invoke(Request $request)
    {
        try {
            self::validate($request);

            $leftUuid = $request->input("left_uuid");
            $rightUuid = $request->input("right_uuid");

            $command = new CreateChatRoomCommand($leftUuid, $rightUuid);
            $this->commandBus->handle($command);

            return Response::OK(null, "Sala creada correctamente");

        } catch (BadRequestException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
