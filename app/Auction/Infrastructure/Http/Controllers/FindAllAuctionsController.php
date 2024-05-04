<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Queries\FindAllAuctions\FindAllAuctionsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllAuctionsController extends QueryController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offset = $request->query->getInt('offset', 0);
            $limit = $request->query->getInt('limit', 10);

            $query = FindAllAuctionsQuery::create($offset, $limit);
            $resources = $this->queryBus->handle($query);

            return Response::OK(
                data: $resources,
                message: "Subastas encontradas"
            );

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
