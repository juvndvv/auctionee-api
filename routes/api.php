<?php

use App\Auction\Infraestructure\Controllers\AuctionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auctions
Route::get('/auctions', [AuctionController::class, 'findAll']);
Route::post('/auctions', [AuctionController::class,'create']);
Route::get('/auctions/{id}', [AuctionController::class,'findById']);
Route::delete('/auctions/{id}', [AuctionController::class,'deleteById']);
