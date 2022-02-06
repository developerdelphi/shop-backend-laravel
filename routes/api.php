<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('signup', [AuthController::class, 'signup'])->name('signup');
Route::post('signin', [AuthController::class, 'signin'])->name('signin');


Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/search/{name}', [ProductsController::class, 'search'])->name('products.search');
    Route::post('/search', [ProductsController::class, 'search'])->name('products.search');
    Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('signout', [AuthController::class, 'signout'])->name('signout');

    Route::prefix('products')->group(function () {
        Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
        Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update');
    });

    Route::prefix('orders')->group(function () {
        //show only orders to authenticated user
        Route::get('/user', [OrdersController::class, 'getByUser'])->name('orders.getByUser');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
