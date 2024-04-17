<?php

use App\Auction\Infraestructure\Controllers\CreateAuctionController;
use App\Auction\Infraestructure\Controllers\DeleteByIdAuctionController;
use App\Auction\Infraestructure\Controllers\FindAllAuctionController;
use App\Auction\Infraestructure\Controllers\FindByIdAuctionController;
use App\Authentication\Infraestructure\Controllers\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Users
Route::post('/register', RegisterUserController::class);

// Auctions
Route::get('/auctions', FindAllAuctionController::class);
Route::post('/auctions', CreateAuctionController::class);
Route::get('/auctions/{id}', FindByIdAuctionController::class);
Route::delete('/auctions/{id}', DeleteByIdAuctionController::class);
