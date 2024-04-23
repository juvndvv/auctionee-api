<?php

use App\Review\Infraestructure\Controllers\FindUserReviewsController;
use App\Review\Infraestructure\Controllers\PlaceReviewController;
use App\Review\Infraestructure\Controllers\RemoveReviewController;
use App\Review\Infraestructure\Controllers\UpdateDescriptionController;
use App\Review\Infraestructure\Controllers\UpdateRatingController;
use App\UserManagement\Infraestructure\Controllers\BlockUserController;
use App\UserManagement\Infraestructure\Controllers\CreateUserController;
use App\UserManagement\Infraestructure\Controllers\DeleteUserController;
use App\UserManagement\Infraestructure\Controllers\FindAllUserController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUuidController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUsernameController;
use App\UserManagement\Infraestructure\Controllers\UnblockUserController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserAvatarController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserEmailController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserNameController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserPasswordController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserUsernameController;
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

// Reviews
Route::post('/reviews', PlaceReviewController::class);
Route::delete('/reviews/{uuid}', RemoveReviewController::class);
Route::put('/reviews/{uuid}/rating', UpdateRatingController::class);
Route::put('/reviews/{uuid}/description', UpdateDescriptionController::class);
