<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Command\RemoveReview\RemoveReviewCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Controllers\CommandController;
use App\Shared\Infrastructure\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class RemoveReviewController extends CommandController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->commandBus->handle(RemoveReviewCommand::create($uuid));
            return Response::OK($uuid, "Review eliminada satisfactoriamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
