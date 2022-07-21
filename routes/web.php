<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;

Route::get('/', [MainController::class, 'index'])
    ->name('main');

Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

Route::resource('products.carts', ProductCartController::class)
    ->only(['store', 'destroy']);

Route::resource('carts', CartController::class)
    ->only(['index']);

Route::resource('orders', OrderController::class)
    ->only(['create', 'store'])
    ->middleware(['verified']);

Route::resource('orders.payments', OrderPaymentController::class)
    ->only(['create', 'store'])
    ->middleware(['verified']);

Auth::routes([
    'verify' => true,
]);


