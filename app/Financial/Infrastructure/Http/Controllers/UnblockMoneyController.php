<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Infrastructure\Repositories\EloquentWalletRepository;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnblockMoneyController
{
    public function __construct(private readonly EloquentWalletRepository $walletRepository)
    {
    }

    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $amount = $request['amount'];

        dd($amount);

        $this->walletRepository->unblockAmount($uuid, $amount);

        return Response::OK('', 'Desbloqueado');
    }
}
