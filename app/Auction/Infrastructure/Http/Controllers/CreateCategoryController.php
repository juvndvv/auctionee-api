<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\CreateCategory\CreateCategoryCommand;
use App\Shared\Application\Commands\UploadImage\UploadImageCommand;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreateCategoryController extends ValidatedCommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $name = $request->get('name');
            $description = $request->get('description');
            $avatar = $request->file('avatar');

            // Upload avatar
            $command = UploadImageCommand::create('categories', $avatar);
            $avatar = $this->commandBus->handle($command);

            // Register category
            $command = CreateCategoryCommand::create($name, $description, $avatar);
            $uuid = $this->commandBus->handle($command);

            return Response::CREATED("Categoria creada correctamente", "/categories/" . $uuid);

        } catch (Exception $exception) {
            dd($exception);
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'string|required',
            'description' => 'string|required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
}
