<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PriceController;
use App\Http\Controllers\API\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//auth
Route::controller(UserController::class)->group(function(){
    Route::post('register', 'registerUser');
    Route::post('login', 'loginUser');
});
//auth

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    //Auth
    Route::post('/logout', [UserController::class, 'logoutUser']);
    //End Auth

    //Product
    Route::controller(ProductController::class)->group(function(){
        Route::get('product', 'index');
        Route::post('product', 'store');
        Route::get('product/{id}', 'show');
        Route::put('product/{id}', 'update');
        Route::delete('product/{id}', 'destroy');
    });
    //End Product

    //Price
    Route::controller(PriceController::class)->group(function(){
        Route::get('price', 'index');
        Route::post('price', 'store');
        Route::get('price/{id}', 'show');
        Route::put('price/{id}', 'update');
        Route::delete('price/{id}', 'destroy');
    });
    
    //End Price

    //Transaction
    Route::controller(TransactionController::class)->group(function(){
        Route::get('transaction', 'index');
        Route::post('transaction', 'store');
        Route::get('transaction/{id}', 'show');
        Route::put('transaction/{id}', 'update');
        Route::delete('transaction/{id}', 'destroy');
    });
    //End Transaction
});