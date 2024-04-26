<?php

namespace App\Financial\Infraestructure\Controllers;

use App\Financial\Application\FindWalletByUserUuid\FindWalletByUserUuidQuery;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

class FindWalletByUserUuidBaseController extends BaseController
{
    public function __construct(
        private readonly QueryBus $queryBus
    )
    {}

    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = new FindWalletByUserUuidQuery($uuid);
            $resource = $this->queryBus->handle($query);
            return Response::OK($resource, "Wallet encontrada");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND("No se ha encontrado la wallet");

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
