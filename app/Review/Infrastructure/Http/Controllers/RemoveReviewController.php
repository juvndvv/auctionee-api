<?php

namespace App\Review\Infrastructure\Http\Controllers;

use App\Review\Application\Command\RemoveReview\RemoveReviewCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class RemoveReviewController extends CommandController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->commandBus->handle(RemoveReviewCommand::create($uuid));
            return Response::OK(
                data: $uuid,
                message: "Review eliminada"
            );

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND(
                message: $e->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
