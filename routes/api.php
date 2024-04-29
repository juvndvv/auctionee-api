<?php

use App\Financial\Infrastructure\Controllers\DepositMoneyController;
use App\Financial\Infrastructure\Controllers\FindTransactionsByWalletUuidController;
use App\Financial\Infrastructure\Controllers\FindWalletByUserUuidController;
use App\Financial\Infrastructure\Controllers\MakeTransactionController;
use App\Financial\Infrastructure\Controllers\WithdrawMoneyController;
use App\Retention\EventMonitoring\Infrastructure\Controllers\FindAllEventsController;
use App\Review\Infrastructure\Controllers\FindUserAverageRatingController;
use App\Review\Infrastructure\Controllers\FindUserReviewsController;
use App\Review\Infrastructure\Controllers\PlaceReviewController;
use App\Review\Infrastructure\Controllers\RemoveReviewController;
use App\Review\Infrastructure\Controllers\UpdateDescriptionController;
use App\Review\Infrastructure\Controllers\UpdateRatingController;
use App\Social\Infrastructure\Controllers\CreateChatRoomController;
use App\Social\Infrastructure\Controllers\DeleteChatMessageBaseController;
use App\Social\Infrastructure\Controllers\FindChatRoomsByUserUuidController;
use App\Social\Infrastructure\Controllers\FindFriendListByUserUuidController;
use App\Social\Infrastructure\Controllers\FindMessagesByChatRoomUuidController;
use App\User\Infrastructure\Controllers\AuthenticateController;
use App\User\Infrastructure\Controllers\BlockUserController;
use App\User\Infrastructure\Controllers\CreateUserController;
use App\User\Infrastructure\Controllers\DeleteUserController;
use App\User\Infrastructure\Controllers\FindAllUserController;
use App\User\Infrastructure\Controllers\FindUserByUsernameController;
use App\User\Infrastructure\Controllers\FindUserByUuidController;
use App\User\Infrastructure\Controllers\UnblockUserController;
use App\User\Infrastructure\Controllers\UpdateUserAvatarController;
use App\User\Infrastructure\Controllers\UpdateUserEmailController;
use App\User\Infrastructure\Controllers\UpdateUserNameController;
use App\User\Infrastructure\Controllers\UpdateUserPasswordController;
use App\User\Infrastructure\Controllers\UpdateUserUsernameController;
use Illuminate\Support\Facades\Route;

// Users
Route::post("/auth", AuthenticateController::class);
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
Route::get("/users/{uuid}/rating", FindUserAverageRatingController::class);
Route::get("/users/{uuid}/wallet", FindWalletByUserUuidController::class);
Route::get("/users/{uuid}/chats", FindChatRoomsByUserUuidController::class);
Route::get("/users/{uuid}/friends", FindFriendListByUserUuidController::class);

// Wallets
Route::get("/wallets/{uuid}/transfer", MakeTransactionController::class);
Route::get("/wallets/{uuid}/transactions", FindTransactionsByWalletUuidController::class);
Route::post("/wallets/{uuid}/deposit", DepositMoneyController::class);
Route::post("/wallets/{uuid}/withdraw", WithdrawMoneyController::class);

// Reviews
Route::post('/reviews', PlaceReviewController::class);
Route::delete('/reviews/{uuid}', RemoveReviewController::class);
Route::put('/reviews/{uuid}/rating', UpdateRatingController::class);
Route::put('/reviews/{uuid}/description', UpdateDescriptionController::class);

// Events
Route::get("/events", FindAllEventsController::class);

// Chat rooms
Route::post("/chats", CreateChatRoomController::class);
Route::get("/chats/{uuid}/messages", FindMessagesByChatRoomUuidController::class);
Route::delete("/chats/{chatUuid}/messages/{messageUuid}", DeleteChatMessageBaseController::class);
