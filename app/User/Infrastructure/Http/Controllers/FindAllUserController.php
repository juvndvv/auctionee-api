<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Application\Queries\FindAll\FindAllUserQuery;
use App\User\Domain\Models\User;
use App\User\Domain\Projections\UserDetailsProjection;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllUserController extends QueryController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offset = $request->input('page', 0) * env('PAGINATION_LIMIT');
            $limit = env('PAGINATION_LIMIT');

            $all = $request->boolean('all', false);

            if ($all) {
                $usersModel = EloquentUserModel::all();
                $userDomain = $usersModel->map(fn ($userModel) => User::fromPrimitives($userModel->toArray()));
                $users = $userDomain->map(fn ($user) => UserDetailsProjection::create($user));

            } else {
                $query = FindAllUserQuery::create($offset, $limit);
                $users = $this->queryBus->handle($query);
            }

            return Response::OK(
                data: $users,
                message: "Usuarios encontrados"
            );

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
