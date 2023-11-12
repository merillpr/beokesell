<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Product
Route::get('product', [ProductController::class, 'index']);
Route::post('product', [ProductController::class, 'store']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);
//End Product

//Price
Route::get('price', [PriceController::class, 'index']);
Route::post('price', [PriceController::class, 'store']);
Route::get('price/{id}', [PriceController::class, 'show']);
Route::put('price/{id}', [PriceController::class, 'update']);
Route::delete('price/{id}', [PriceController::class, 'destroy']);
//End Price

//Transaction
Route::get('transaction', [TransactionController::class, 'index']);
Route::post('transaction', [TransactionController::class, 'store']);
Route::get('transaction/{id}', [TransactionController::class, 'show']);
Route::put('transaction/{id}', [TransactionController::class, 'update']);
Route::delete('transaction/{id}', [TransactionController::class, 'destroy']);
//End Transaction