<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ExchangeRateController;

Route::get('purchases', [PurchaseController::class, 'index']);
Route::post('purchases', [PurchaseController::class, 'store']);
Route::put('purchases/{id}', [PurchaseController::class, 'update']);
Route::delete('purchases/{id}', [PurchaseController::class, 'destroy']);

Route::get('shops', [ShopController::class, 'index']);
Route::get('shops/{id}/purchases', [ShopController::class, 'purchasesByShop']);

Route::get('exchange-rates', [ExchangeRateController::class, 'index']);
