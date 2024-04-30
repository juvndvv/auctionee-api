<?php

use App\Auction\Infrastructure\Http\Controllers\CreateAuctionController;
use App\Auction\Infrastructure\Http\Controllers\CreateCategoryController;
use App\Auction\Infrastructure\Http\Controllers\FindAllCategoriesController;
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
use App\Shared\Infrastructure\Http\Middleware\EnsureOwnUserMiddleware;
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

Route::prefix('v1')->group(function () {
    // Users
    Route::post('/auth', AuthenticateController::class);
    Route::post('/users', CreateUserController::class);
    Route::get('/users', FindAllUserController::class);
    Route::get('/users/{uuid}', FindUserByUuidController::class);
    Route::get('/users/username/{username}', FindUserByUsernameController::class);
    Route::delete('/users/{uuid}', DeleteUserController::class);
    Route::post('/users/{uuid}/avatar', UpdateUserAvatarController::class);
    Route::put('/users/{uuid}/email', UpdateUserEmailController::class);
    Route::put('/users/{uuid}/name', UpdateUserNameController::class);
    Route::put('/users/{uuid}/username', UpdateUserUsernameController::class);
    Route::put('/users/{uuid}/password', UpdateUserPasswordController::class);
    Route::get('/users/{uuid}/block', BlockUserController::class);
    Route::get('/users/{uuid}/unblock', UnblockUserController::class);
    Route::get('/users/{uuid}/reviews', FindUserReviewsController::class);
    Route::get('/users/{uuid}/rating', FindUserAverageRatingController::class);
    Route::get('/users/{uuid}/wallet', FindWalletByUserUuidController::class);
    Route::get('/users/{uuid}/chats', FindChatRoomsByUserUuidController::class);

    // Wallets
    Route::get('/wallets/{uuid}/transfer', MakeTransactionController::class);
    Route::get('/wallets/{uuid}/transactions', FindTransactionsByWalletUuidController::class);
    Route::post('/wallets/{uuid}/deposit', DepositMoneyController::class);
    Route::post('/wallets/{uuid}/withdraw', WithdrawMoneyController::class);

    // Reviews
    Route::post('/reviews', PlaceReviewController::class);
    Route::delete('/reviews/{uuid}', RemoveReviewController::class);
    Route::put('/reviews/{uuid}/rating', UpdateRatingController::class);
    Route::put('/reviews/{uuid}/description', UpdateDescriptionController::class);

    // Events
    Route::get('/events', FindAllEventsController::class);

    // Chat rooms
    Route::post('/chats', CreateChatRoomController::class);
    Route::post('chats/{uuid}', SendMessageController::class)->middleware('auth:sanctum');
    Route::get('/chats/{uuid}/messages', FindMessagesByChatRoomUuidController::class);
    Route::get('/users/{uuid}/chats', FindChatRoomsByUserUuidController::class);
    Route::delete('/chats/{chatUuid}/messages/{messageUuid}', DeleteChatMessageController::class);

    // Categories
    Route::get('/categories', FindAllCategoriesController::class);
    Route::post('/categories', CreateCategoryController::class);
    Route::put('/categories/{uuid}/name', UpdateCategoryNameController::class);
    Route::put('/categories/{uuid}/description', UpdateCategoryDescriptionController::class);
    Route::post('/categories/{uuid}/avatar', UpdateCategoryAvatarController::class);

    // Auctions
    Route::post('/auctions', CreateAuctionController::class);
});

