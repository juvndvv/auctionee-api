<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\PlaceBid\PlaceBidCommand;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Auction\Infrastructure\Repositories\Models\EloquentBidModel;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Infrastructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

            return Response::OK(
                data: $amount,
                message: "Se ha pujado correctamente"
            );

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación",
                error: $exception->validator->getMessageBag()
            );

        } catch (Exception $exception) {
            dd($exception);
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

        // Auction validations
        $auctionUuid = $request->input("auction_uuid");
        $auction = EloquentAuctionModel::query()
            ->select([
                'user_uuid',
                'starting_date',
                'duration'
            ])->where('uuid', $auctionUuid)
            ->first();

        // Bidder is not owner
        $customValidator->after(function ($customValidator) use ($request, $auction) {
            if ($request->user()->uuid === $auction->user_uuid) {
                $customValidator->errors()->add('owner', 'El propietario no puede pujar');
            }
        });

        if ($customValidator->fails()) {
            throw new ValidationException($customValidator);
        }

        // Is live validation
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
            ->select(Wallet::BALANCE)
            ->where(Wallet::USER_UUID, $userUuid)
            ->first();

        $customValidator->after(function ($validator) use ($customValidator, $wallet, $amount) {
            if ($wallet->balance < $amount) {
                $customValidator->errors()->add('money', 'No tienes sufiente dinero');
            }
        });

        // Previous bid validation
        $topBid = EloquentBidModel::query()
            ->select([
                'amount',
                'user_uuid'
                ])
            ->where('auction_uuid', $auctionUuid)
            ->orderBy('amount', 'desc')
            ->limit(1)
            ->first();

        // Previous bid user validation
        $customValidator->after(function ($customValidator) use ($request, $topBid) {
            if (!is_null($topBid) && $request->user()->uuid === $topBid->user_uuid) {
                $customValidator->errors()->add('user_uuid', 'No se puede pujar dos veces seguidas');
            }
        });

        // Previous bid amount validation
        if (!is_null($topBid)) {
            $customValidator->after(function ($customValidator) use ($topBid, $amount) {
                if ($amount <= $topBid->amount) {
                    $customValidator->errors()->add('amount', 'La cantidad debe ser superior a la de la anterior puja');
                }
            });
        }

        if ($customValidator->fails()) {
            throw new ValidationException($customValidator);
        }
    }
}
