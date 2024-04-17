<?php

use App\Auction\Infraestructure\Controllers\CreateAuctionController;
use App\Auction\Infraestructure\Controllers\DeleteByIdAuctionController;
use App\Auction\Infraestructure\Controllers\FindAllAuctionController;
use App\Auction\Infraestructure\Controllers\FindByIdAuctionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auctions
Route::get('/auctions', FindAllAuctionController::class);
Route::post('/auctions', CreateAuctionController::class);
Route::get('/auctions/{id}', FindByIdAuctionController::class);
Route::delete('/auctions/{id}', DeleteByIdAuctionController::class);
