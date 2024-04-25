<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\CreateChatRoom\CreateChatRoomCommand;
use Exception;
use Illuminate\Http\Request;

class CreateChatRoomBaseController extends BaseController
{
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {}

    public function __invoke(Request $request)
    {
        try {
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
}
