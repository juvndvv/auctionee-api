<?php

use App\Auction\Infrastructure\Http\Controllers\CreateAuctionController;
use App\Auction\Infrastructure\Http\Controllers\CreateCategoryController;
use App\Auction\Infrastructure\Http\Controllers\FindAllCategoriesController;
use App\Auction\Infrastructure\Http\Controllers\UpdateAuctionAvatarController;
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
use App\Social\Infrastructure\Http\Controllers\CreateChatRoomController;
use App\Social\Infrastructure\Http\Controllers\DeleteChatMessageController;
use App\Social\Infrastructure\Http\Controllers\FindChatRoomsByUserUuidController;
use App\Social\Infrastructure\Http\Controllers\FindMessagesByChatRoomUuidController;
use App\Social\Infrastructure\Http\Controllers\SendMessageController;
use App\User\Infrastructure\Http\Controllers\AuthenticateController;
use App\User\Infrastructure\Http\Controllers\BlockUserController;
use App\User\Infrastructure\Http\Controllers\CreateUserController;
use App\User\Infrastructure\Http\Controllers\DeleteUserController;
use App\User\Infrastructure\Http\Controllers\FindAllUserController;
use App\User\Infrastructure\Http\Controllers\FindUserByUsernameController;
use App\User\Infrastructure\Http\Controllers\FindUserByUuidController;
use App\User\Infrastructure\Http\Controllers\UnblockUserController;
use App\User\Infrastructure\Http\Controllers\UpdateUserAvatarController;
use App\User\Infrastructure\Http\Controllers\UpdateUserEmailController;
use App\User\Infrastructure\Http\Controllers\UpdateUserNameController;
use App\User\Infrastructure\Http\Controllers\UpdateUserPasswordController;
use App\User\Infrastructure\Http\Controllers\UpdateUserUsernameController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {

    Route::post('/auth', AuthenticateController::class);

    // Users
    Route::prefix('/users')->group(function () {
        Route::post('/', CreateUserController::class);
        Route::get('/', FindAllUserController::class);
        Route::get('/{uuid}', FindUserByUuidController::class);
        Route::get('/username/{username}', FindUserByUsernameController::class);
        Route::delete('/{uuid}', DeleteUserController::class);
        Route::post('/{uuid}/avatar', UpdateUserAvatarController::class);
        Route::put('/{uuid}/email', UpdateUserEmailController::class);
        Route::put('/{uuid}/name', UpdateUserNameController::class);
        Route::put('/{uuid}/username', UpdateUserUsernameController::class);
        Route::put('/{uuid}/password', UpdateUserPasswordController::class);
        Route::get('/{uuid}/block', BlockUserController::class);
        Route::get('/{uuid}/unblock', UnblockUserController::class);
        Route::get('/{uuid}/reviews', FindUserReviewsController::class);
        Route::get('/{uuid}/rating', FindUserAverageRatingController::class);
        Route::get('/{uuid}/wallet', FindWalletByUserUuidController::class);
        Route::get('/{uuid}/chats', FindChatRoomsByUserUuidController::class);
    });

    // Wallets
    Route::prefix('/wallets')->group(function () {
        Route::get('/{uuid}/transfer', MakeTransactionController::class);
        Route::get('/{uuid}/transactions', FindTransactionsByWalletUuidController::class);
        Route::post('/{uuid}/deposit', DepositMoneyController::class);
        Route::post('/{uuid}/withdraw', WithdrawMoneyController::class);
    });

    // Reviews
    Route::prefix('/reviews')->group(function () {
        Route::post('/', PlaceReviewController::class);
        Route::delete('/{uuid}', RemoveReviewController::class);
        Route::put('/{uuid}/rating', UpdateRatingController::class);
        Route::put('/{uuid}/description', UpdateDescriptionController::class);
    });

    // Events
    Route::get('/events', FindAllEventsController::class);

    // Chat rooms
    Route::prefix('/chats')->group(function () {
        Route::post('/', CreateChatRoomController::class);
        Route::post('/{uuid}', SendMessageController::class)->middleware('auth:sanctum');
        Route::get('/{uuid}/messages', FindMessagesByChatRoomUuidController::class);
        Route::delete('/{chatUuid}/messages/{messageUuid}', DeleteChatMessageController::class);
    });

    // Categories
    Route::prefix('/categories')->group(function () {
        Route::get('/', FindAllCategoriesController::class);
        Route::post('/', CreateCategoryController::class);
        Route::put('/{uuid}/name', UpdateCategoryNameController::class);
        Route::put('/{uuid}/description', UpdateCategoryDescriptionController::class);
        Route::post('/{uuid}/avatar', UpdateCategoryAvatarController::class);
    });

    // Auctions
    Route::prefix('/auctions')->group(function () {
        Route::post('/', CreateAuctionController::class)->middleware('auth:sanctum');
        Route::post('/{uuid}/avatar', UpdateAuctionAvatarController::class);
    });
});

