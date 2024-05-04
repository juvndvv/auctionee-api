<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Application\Query\FindTransactionsByWalletUuid\FindTransactionsByWalletUuidQuery;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindTransactionsByWalletUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = new FindTransactionsByWalletUuidQuery($uuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK(
                data: $resources,
                message: "Transacciones encontradas"
            );

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND(
                message: $e->getMessage(),
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
