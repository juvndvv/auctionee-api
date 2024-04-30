<?php

namespace App\Auction\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreateCategoryController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {


        } catch (Exception $exception) {
            dd($exception);
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
