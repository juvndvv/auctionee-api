<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\CreateAuction\CreateAuctionCommand;
use App\Shared\Application\Commands\UploadImage\UploadImageCommand;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Validation\ValidationException;

final class CreateAuctionController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $status = 'READY';
            $categoryUuid = $request->input('category_uuid');
            $userUuid = $request->user()->uuid;               // TODO: from token
            $name = $request->input('name');
            $description = $request->input('description');
            $startingPrice = $request->float('starting_price');
            $startingDate = $request->input('starting_date');
            $duration = $request->integer('duration');
            $avatar  = $request->file('avatar');

            // Upload avatar
            $command = UploadImageCommand::create('auctions', $avatar);
            $avatar = $this->commandBus->handle($command);

            // Create auction
            $command = CreateAuctionCommand::create(
                $categoryUuid,
                $userUuid,
                $name,
                $description,
                $status,
                $startingPrice,
                $startingDate,
                $duration,
                $avatar
            );
            $uuid = $this->commandBus->handle($command);

            return Response::CREATED("Subasta creada con exito", "/auctions/" .  $uuid);

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validacion", $exception->validator->getMessageBag());

        } catch (Exception $exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $validStatus = '';

        $request->validate([
            'category_uuid' => 'required|exists:categories,uuid',
            'name' => 'required',
            'description' => 'required',
            'starting_price' => 'required|numeric|decimal:2',
            'starting_date' => 'required|date|date_format:Y-m-d H:i:s',
            'duration' => 'required|integer|min:1',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
    }
}
