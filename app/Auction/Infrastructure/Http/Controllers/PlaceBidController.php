<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\PlaceBid\PlaceBidCommand;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Auction\Infrastructure\Repositories\Models\EloquentBidModel;
use App\Financial\Infrastructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use function Laravel\Prompts\select;
use function PHPUnit\Framework\isNull;

final class PlaceBidController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $userUuid = $request->user()->uuid;
            $amount = $request->float('amount');
            $auctionUuid = $request->input("auction_uuid");

            $command = PlaceBidCommand::create($userUuid, $amount, $auctionUuid);
            $this->commandBus->handle($command);

            return Response::OK(null, "Se ha pujado correctamente");

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación", $exception->validator->getMessageBag());

        } catch (Exception $exception) {
            return Response::SERVER_ERROR();
        }
    }

    /**
     * @throws ValidationException
     */
    static function validate(Request $request): void
    {
        // Simple validations
        $customValidator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'auction_uuid' => 'required|string|exists:auctions,uuid'
        ]);

        // Auction live validation
        $auctionUuid = $request->input("auction_uuid");
        $auction = EloquentAuctionModel::query()
            ->select([
                'starting_date',
                'duration'
            ])->where('uuid', $auctionUuid)
            ->first();


        $customValidator->after(function ($customValidator) use ($auctionUuid, $auction) {
            if (strtotime($auction->starting_date) > strtotime(now())) {
                $customValidator->errors()->add('time','La subasta no ha empezado');

            }  elseif (strtotime($auction->starting_date) + $auction->duration * 60 < strtotime(now())) {
                $customValidator->errors()->add('time', 'La subasta ha finalizado');
            }
        });

        if ($customValidator->fails()) {
            throw new ValidationException($customValidator);
        }

        // Wallet amount validation
        $userUuid = $request->user()->uuid;
        $amount = $request->input("amount");
        $wallet = EloquentWalletModel::query()
            ->select('amount')
            ->where('user_uuid', $userUuid)
            ->first();

        $customValidator->after(function ($validator) use ($customValidator, $wallet, $amount) {
            if ($wallet->amount < $amount) {
                $customValidator->errors()->add('money', 'No tienes sufiente dinero');
            }
        });

        // Bid amount validation
        $topBid = EloquentBidModel::query()
            ->select('amount')
            ->where('auction_uuid', $auctionUuid)
            ->orderBy('amount', 'desc')
            ->limit(1)
            ->first();

        if (!is_null($topBid)) {
            $topBidAmount = $topBid->amount;

        } else {
            $topBidAmount = 0;
        }

        $customValidator->after(function ($customValidator) use ($topBidAmount, $amount) {
            if ($amount <= $topBidAmount) {
                $customValidator->errors()->add('amount', 'La cantidad debe ser superior a la de la anterior puja');
            }
        });

        if ($customValidator->fails()) {
            throw new ValidationException($customValidator);
        }
    }
}
