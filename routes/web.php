<?php

use App\Http\Controllers\CartController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app', [
        'products' => Product::all(),
        'cart' => Cart::current(),
    ]);
})->name('home');

Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'reduce'])->name('cart.reduce');
Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
