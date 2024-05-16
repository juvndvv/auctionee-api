<?php

use App\Auction\Infrastructure\Http\Controllers\CreateAuctionController;
use App\Auction\Infrastructure\Http\Controllers\CreateCategoryController;
use App\Auction\Infrastructure\Http\Controllers\DeleteAuctionController;
use App\Auction\Infrastructure\Http\Controllers\DeleteCategoryController;
use App\Auction\Infrastructure\Http\Controllers\FindAllAuctionsByUserUuidController;
use App\Auction\Infrastructure\Http\Controllers\FindAllAuctionsController;
use App\Auction\Infrastructure\Http\Controllers\FindAllCategoriesController;
use App\Auction\Infrastructure\Http\Controllers\FindAuctionByCategoryUuid;
use App\Auction\Infrastructure\Http\Controllers\FindAuctionByUuidController;
use App\Auction\Infrastructure\Http\Controllers\FindTotalAuctions;
use App\Auction\Infrastructure\Http\Controllers\PlaceBidController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionAvatarController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionDescriptionController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionDurationController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionNameController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionStartingDateController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionStartingPriceController;
use App\Auction\Infrastructure\Http\Controllers\UpdateCategoryAvatarController;
use App\Auction\Infrastructure\Http\Controllers\UpdateCategoryDescriptionController;
use App\Auction\Infrastructure\Http\Controllers\UpdateCategoryNameController;
use App\Financial\Infrastructure\Http\Controllers\DepositMoneyController;
use App\Financial\Infrastructure\Http\Controllers\FindTransactionsByWalletUuidController;
use App\Financial\Infrastructure\Http\Controllers\FindWalletByUserUuidController;
use App\Financial\Infrastructure\Http\Controllers\MakeTransactionController;
use App\Financial\Infrastructure\Http\Controllers\WithdrawMoneyController;
use App\Retention\EventMonitoring\Infrastructure\Controllers\FindAllEventsController;
use App\Review\Infrastructure\Http\Controllers\FindUserAverageRatingController;
use App\Review\Infrastructure\Http\Controllers\FindUserReviewsController;
use App\Review\Infrastructure\Http\Controllers\PlaceReviewController;
use App\Review\Infrastructure\Http\Controllers\RemoveReviewController;
use App\Review\Infrastructure\Http\Controllers\UpdateDescriptionController;
use App\Review\Infrastructure\Http\Controllers\UpdateRatingController;
use App\Shared\Infrastructure\Http\Middleware\cors;
use App\Social\Infrastructure\Http\Controllers\CreateChatRoomController;
use App\Social\Infrastructure\Http\Controllers\DeleteChatMessageController;
use App\Social\Infrastructure\Http\Controllers\FindChatRoomsByUserUuidController;
use App\Social\Infrastructure\Http\Controllers\FindMessagesByChatRoomUuidController;
use App\Social\Infrastructure\Http\Controllers\SendMessageController;
use App\User\Infrastructure\Http\Controllers\AuthenticateController;
use App\User\Infrastructure\Http\Controllers\BlockUserController;
use App\User\Infrastructure\Http\Controllers\CreateUserController;
use App\User\Infrastructure\Http\Controllers\DeleteUserController;
use App\User\Infrastructure\Http\Controllers\ExistsEmailController;
use App\User\Infrastructure\Http\Controllers\ExistsUsernameController;
use App\User\Infrastructure\Http\Controllers\FindAllUserController;
use App\User\Infrastructure\Http\Controllers\FindUserByToken;
use App\User\Infrastructure\Http\Controllers\FindUserByUsernameController;
use App\User\Infrastructure\Http\Controllers\FindUserByUuidController;
use App\User\Infrastructure\Http\Controllers\FindUserLikeController;
use App\User\Infrastructure\Http\Controllers\LogoutController;
use App\User\Infrastructure\Http\Controllers\PromoteAdminController;
use App\User\Infrastructure\Http\Controllers\PromoteUserController;
use App\User\Infrastructure\Http\Controllers\UnblockUserController;
use App\User\Infrastructure\Http\Controllers\UpdateUserAvatarController;
use App\User\Infrastructure\Http\Controllers\UpdateUserEmailController;
use App\User\Infrastructure\Http\Controllers\UpdateUserNameController;
use App\User\Infrastructure\Http\Controllers\UpdateUserPasswordController;
use App\User\Infrastructure\Http\Controllers\UpdateUserUsernameController;
use App\User\Infrastructure\Http\Controllers\UserCountController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', cors::class]], function () {
    Route::prefix('/v1')->group(function () {
        Route::post('/auth', AuthenticateController::class)->withoutMiddleware('auth:sanctum');
        Route::get('/logout', LogoutController::class);
        Route::post('/token', FindUserByToken::class);

        // Users
        Route::prefix('/users')->group(function () {
            Route::get('/count', UserCountController::class);
            Route::get('like/{str}', FindUserLikeController::class);
            // Public
            Route::post('/', CreateUserController::class)->withoutMiddleware('auth:sanctum');
            Route::post('/existsUsername', ExistsUsernameController::class)->withoutMiddleware('auth:sanctum');
            Route::post('/existsEmail', ExistsEmailController::class)->withoutMiddleware('auth:sanctum');

            // Auth
            Route::get('/{uuid}', FindUserByUuidController::class);
            Route::get('/username/{username}', FindUserByUsernameController::class);
            Route::get('/{uuid}/reviews', FindUserReviewsController::class);
            Route::get('/{uuid}/rating', FindUserAverageRatingController::class);
            Route::get('/{uuid}/wallet', FindWalletByUserUuidController::class);
            Route::get('/{uuid}/chats', FindChatRoomsByUserUuidController::class);
            Route::get('/{uuid}/auctions', FindAllAuctionsByUserUuidController::class);

            // Admin
            Route::get('/', FindAllUserController::class);
            Route::delete('/{uuid}', DeleteUserController::class);
            Route::get('/{uuid}/block', BlockUserController::class);
            Route::get('/{uuid}/unblock', UnblockUserController::class);
            Route::get('/{uuid}/admin', PromoteAdminController::class);
            Route::get('/{uuid}/user', PromoteUserController::class);

            // Owner
            Route::post('/{uuid}/avatar', UpdateUserAvatarController::class);
            Route::put('/{uuid}/email', UpdateUserEmailController::class);
            Route::put('/{uuid}/name', UpdateUserNameController::class);
            Route::put('/{uuid}/username', UpdateUserUsernameController::class);
            Route::put('/{uuid}/password', UpdateUserPasswordController::class);
        });

        // Wallets
        Route::prefix('/wallets')->group(function () {
            // Owner
            Route::get('/{uuid}/transfer', MakeTransactionController::class);
            Route::get('/{uuid}/transactions', FindTransactionsByWalletUuidController::class);
            Route::post('/{uuid}/deposit', DepositMoneyController::class);
            Route::post('/{uuid}/withdraw', WithdrawMoneyController::class);
        });

        // Reviews
        Route::prefix('/reviews')->group(function () {
            // Auth
            Route::post('/', PlaceReviewController::class);

            // Owner
            Route::delete('/{uuid}', RemoveReviewController::class);
            Route::put('/{uuid}/rating', UpdateRatingController::class);
            Route::put('/{uuid}/description', UpdateDescriptionController::class);
        });

        // Events (ADMIN)
        Route::get('/events', FindAllEventsController::class);

        // Chat rooms
        Route::prefix('/chats')->group(function () {
            // Auth
            Route::post('/', CreateChatRoomController::class);

            // Auth and participant
            Route::post('/{uuid}', SendMessageController::class);
            Route::get('/{uuid}/messages', FindMessagesByChatRoomUuidController::class);

            // Owner
            Route::delete('/{chatUuid}/messages/{messageUuid}', DeleteChatMessageController::class);
        });

        // Categories
        Route::prefix('/categories')->group(function () {
            // Auth
            Route::get('/', FindAllCategoriesController::class);
            Route::delete('/{uuid}', DeleteCategoryController::class);
            Route::get('/{uuid}/auctions', FindAuctionByCategoryUuid::class);
            // ADMIN
            Route::post('/', CreateCategoryController::class);
            Route::put('/{uuid}/name', UpdateCategoryNameController::class);
            Route::put('/{uuid}/description', UpdateCategoryDescriptionController::class);
            Route::post('/{uuid}/avatar', UpdateCategoryAvatarController::class);
        });

        // Auctions
        Route::prefix('/auctions')->group(function () {
            Route::delete('/{uuid}', DeleteAuctionController::class);
            Route::get('/count', FindTotalAuctions::class);
            // Auth
            Route::get('/', FindAllAuctionsController::class);
            Route::post('/', CreateAuctionController::class);
            Route::get('/{uuid}', FindAuctionByUuidController::class);

            // Owner
            Route::post('/{uuid}/avatar', UpdateAuctionAvatarController::class);
            Route::put('/{uuid}/name', UpdateAuctionNameController::class);
            Route::put('/{uuid}/description', UpdateAuctionDescriptionController::class);
            Route::put('/{uuid}/price', UpdateAuctionStartingPriceController::class);
            Route::put('/{uuid}/date', UpdateAuctionStartingDateController::class);
            Route::put('/{uuid}/duration', UpdateAuctionDurationController::class);
        });

        // Auth
        Route::post('/bids', PlaceBidController::class);
    });
});

