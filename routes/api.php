<?php

use App\UserManagement\Infraestructure\Controllers\CreateUserController;
use App\UserManagement\Infraestructure\Controllers\FindAllUserController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUsernameController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserAvatarController;
use App\UserManagement\Infraestructure\Controllers\UpdateUserEmailController;
use Illuminate\Support\Facades\Route;

// Users
Route::post('/register', CreateUserController::class);
Route::get('/users', FindAllUserController::class);
Route::get('/users/{username}', FindUserByUsernameController::class);
Route::post('/users/{uuid}/avatar', UpdateUserAvatarController::class);
Route::put('/users/{uuid}/email', UpdateUserEmailController::class);
