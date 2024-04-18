<?php

use App\Auction\Infraestructure\Controllers\CreateAuctionController;
use App\Auction\Infraestructure\Controllers\DeleteByIdAuctionController;
use App\Auction\Infraestructure\Controllers\FindAllAuctionController;
use App\Auction\Infraestructure\Controllers\FindByIdAuctionController;
use Illuminate\Support\Facades\Route;

// Users
Route::post('/register', \App\UserManagement\Infraestructure\Controllers\CreateUserController::class);
Route::get('/users', \App\UserManagement\Infraestructure\Controllers\FindAllUserController::class);

// Auctions
Route::get('/auctions', FindAllAuctionController::class);
Route::post('/auctions', CreateAuctionController::class);
Route::get('/auctions/{id}', FindByIdAuctionController::class);
Route::delete('/auctions/{id}', DeleteByIdAuctionController::class);
