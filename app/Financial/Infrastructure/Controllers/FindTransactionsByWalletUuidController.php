<?php

namespace App\Financial\Infrastructure\Controllers;

use App\Financial\Application\Query\FindTransactionsByWalletUuid\FindTransactionsByWalletUuidQuery;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindTransactionsByWalletUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = new FindTransactionsByWalletUuidQuery($uuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Transacciones encontradas");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}