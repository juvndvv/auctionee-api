<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Application\Query\FindWalletByUserUuid\FindWalletByUserUuidQuery;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindWalletByUserUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = new FindWalletByUserUuidQuery($uuid);
            $resource = $this->queryBus->handle($query);
            return Response::OK($resource, "Wallet encontrada");

        } catch (NotFoundException) {
            return Response::NOT_FOUND("No se ha encontrado la wallet");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
