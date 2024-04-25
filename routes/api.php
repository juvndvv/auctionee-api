<?php

use App\Financial\Infraestructure\Controllers\DepositMoneyBaseController;
use App\Financial\Infraestructure\Controllers\FindTransactionsByWalletUuidBaseController;
use App\Financial\Infraestructure\Controllers\FindWalletByUserUuidBaseController;
use App\Financial\Infraestructure\Controllers\MakeTransactionBaseController;
use App\Financial\Infraestructure\Controllers\WithdrawMoneyBaseController;
use App\Retention\EventMonitoring\Infraestructure\Controllers\FindAllEventsBaseController;
use App\Review\Infraestructure\Controllers\FindUserAverageRatingController;
use App\Review\Infraestructure\Controllers\FindUserReviewsController;
use App\Review\Infraestructure\Controllers\PlaceReviewBaseController;
use App\Review\Infraestructure\Controllers\RemoveReviewController;
use App\Review\Infraestructure\Controllers\UpdateDescriptionController;
use App\Review\Infraestructure\Controllers\UpdateRatingController;
use App\Social\Infraestructure\Controllers\CreateChatRoomBaseController;
use App\Social\Infraestructure\Controllers\DeleteChatMessageBaseController;
use App\Social\Infraestructure\Controllers\FindChatRoomsByUserUuidBaseController;
use App\Social\Infraestructure\Controllers\FindFriendListByUserUuidBaseController;
use App\Social\Infraestructure\Controllers\FindMessagesByChatRoomUuidBaseController;
use App\Social\Infraestructure\Controllers\SendMessageBaseController;
use App\UserManagement\Infraestructure\Controllers\BlockUserController;
use App\UserManagement\Infraestructure\Controllers\CreateUserController;
use App\UserManagement\Infraestructure\Controllers\DeleteUserController;
use App\UserManagement\Infraestructure\Controllers\FindAllUserBaseController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUuidBaseController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUsernameBaseController;
use App\UserManagement\Infraestructure\Controllers\UnblockUserController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserAvatarBaseController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserEmailBaseController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserNameBaseController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserPasswordBaseController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserUsernameBaseController;
use Illuminate\Support\Facades\Route;

// Users
Route::post('/users', CreateUserController::class);
Route::get('/users', FindAllUserBaseController::class);
Route::get('/users/{uuid}', FindUserByUuidBaseController::class);
Route::get('/users/username/{username}', FindUserByUsernameBaseController::class);
Route::delete('/users/{uuid}', DeleteUserController::class);
Route::post('/users/{uuid}/avatar', UpdateUserAvatarBaseController::class);
Route::put('/users/{uuid}/email', UpdateUserEmailBaseController::class);
Route::put('/users/{uuid}/name', UpdateUserNameBaseController::class);
Route::put('/users/{uuid}/username', UpdateUserUsernameBaseController::class);
Route::put('/users/{uuid}/password', UpdateUserPasswordBaseController::class);
Route::get('/users/{uuid}/block', BlockUserController::class);
Route::get('/users/{uuid}/unblock', UnblockUserController::class);
Route::get('/users/{uuid}/reviews', FindUserReviewsController::class);
Route::get("/users/{uuid}/rating", FindUserAverageRatingController::class);
Route::get("/users/{uuid}/wallet", FindWalletByUserUuidBaseController::class);
Route::get("/users/{uuid}/chats", FindChatRoomsByUserUuidBaseController::class);
Route::get("/users/{uuid}/friends", FindFriendListByUserUuidBaseController::class);

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
Route::get("/events", FindAllEventsBaseController::class);

// Chat rooms
Route::post("/chats", CreateChatRoomBaseController::class);
Route::post("/chats/{uuid}/send", SendMessageBaseController::class);
Route::get("/chats/{uuid}/messages", FindMessagesByChatRoomUuidBaseController::class);
Route::delete("/chats/{chatUuid}/messages/{messageUuid}", DeleteChatMessageBaseController::class);
