<?php

use App\Financial\Infraestructure\Controllers\DepositMoneyBaseController;
use App\Financial\Infraestructure\Controllers\FindTransactionsByWalletUuidBaseController;
use App\Financial\Infraestructure\Controllers\FindWalletByUserUuidBaseController;
use App\Financial\Infraestructure\Controllers\MakeTransactionBaseController;
use App\Financial\Infraestructure\Controllers\WithdrawMoneyBaseController;
use App\Retention\EventMonitoring\Infraestructure\Controllers\FindAllEventsController;
use App\Review\Infraestructure\Controllers\FindUserAverageRatingController;
use App\Review\Infraestructure\Controllers\FindUserReviewsController;
use App\Review\Infraestructure\Controllers\PlaceReviewBaseController;
use App\Review\Infraestructure\Controllers\RemoveReviewController;
use App\Review\Infraestructure\Controllers\UpdateDescriptionController;
use App\Review\Infraestructure\Controllers\UpdateRatingController;
use App\Social\Infraestructure\Controllers\CreateChatRoomBaseController;
use App\Social\Infraestructure\Controllers\DeleteChatMessageBaseController;
use App\Social\Infraestructure\Controllers\FindChatRoomsByUserUuidController;
use App\Social\Infraestructure\Controllers\FindFriendListByUserUuidController;
use App\Social\Infraestructure\Controllers\FindMessagesByChatRoomUuidController;
use App\User\Infraestructure\Controllers\BlockUserController;
use App\User\Infraestructure\Controllers\CreateUserController;
use App\User\Infraestructure\Controllers\DeleteUserController;
use App\User\Infraestructure\Controllers\FindAllUserController;
use App\User\Infraestructure\Controllers\FindUserByUuidController;
use App\User\Infraestructure\Controllers\FindUserByUsernameController;
use App\User\Infraestructure\Controllers\UnblockUserController;
use App\User\Infraestructure\Controllers\UpdateUserAvatarController;
use App\User\Infraestructure\Controllers\UpdateUserEmailController;
use App\User\Infraestructure\Controllers\UpdateUserNameController;
use App\User\Infraestructure\Controllers\UpdateUserPasswordController;
use App\User\Infraestructure\Controllers\UpdateUserUsernameController;
use Illuminate\Support\Facades\Route;

// Users
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
Route::get("/users/{uuid}/wallet", FindWalletByUserUuidBaseController::class);
Route::get("/users/{uuid}/chats", FindChatRoomsByUserUuidController::class);
Route::get("/users/{uuid}/friends", FindFriendListByUserUuidController::class);

// Wallets
Route::get("/wallets/{uuid}/transfer", MakeTransactionBaseController::class);
Route::get("/wallets/{uuid}/transactions", FindTransactionsByWalletUuidBaseController::class);
Route::post("/wallets/{uuid}/deposit", DepositMoneyBaseController::class);
Route::post("/wallets/{uuid}/withdraw", WithdrawMoneyBaseController::class);

// Reviews
Route::post('/reviews', PlaceReviewBaseController::class);
Route::delete('/reviews/{uuid}', RemoveReviewController::class);
Route::put('/reviews/{uuid}/rating', UpdateRatingController::class);
Route::put('/reviews/{uuid}/description', UpdateDescriptionController::class);

// Events
Route::get("/events", FindAllEventsController::class);

// Chat rooms
Route::post("/chats", CreateChatRoomBaseController::class);
Route::get("/chats/{uuid}/messages", FindMessagesByChatRoomUuidController::class);
Route::delete("/chats/{chatUuid}/messages/{messageUuid}", DeleteChatMessageBaseController::class);
