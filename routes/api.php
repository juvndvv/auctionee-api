<?php

use App\UserManagement\Infraestructure\Controllers\CreateUserController;
use App\UserManagement\Infraestructure\Controllers\FindAllUserController;
use App\UserManagement\Infraestructure\Controllers\FindUserByUsernameController;
use Illuminate\Support\Facades\Route;

// Users
Route::post('/register', CreateUserController::class);
Route::get('/users', FindAllUserController::class);
Route::get('/users/{username}', FindUserByUsernameController::class);

// Auctions
Route::get('/auctions', FindAllAuctionController::class);
Route::post('/auctions', CreateAuctionController::class);
Route::get('/auctions/{id}', FindByIdAuctionController::class);
Route::delete('/auctions/{id}', DeleteByIdAuctionController::class);
