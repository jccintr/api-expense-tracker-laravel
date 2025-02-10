<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/login',[AuthController::class,'login']);

/*
Route::apiResources([
    'categories' => CategoryController::class,
    'accounts' => AccountController::class,
    'transactions' => TransactionController::class,
]);
*/

// Category Routes
Route::middleware('auth:sanctum')->get('/categories',[CategoryController::class,'index']);
Route::middleware('auth:sanctum')->post('/categories',[CategoryController::class,'store']);
Route::middleware('auth:sanctum')->put('/categories/{id}',[CategoryController::class,'update']);
Route::middleware('auth:sanctum')->delete('/categories/{id}',[CategoryController::class,'destroy']);
// Account Routes
Route::middleware('auth:sanctum')->get('/accounts',[AccountController::class,'index']);
Route::middleware('auth:sanctum')->post('/accounts',[AccountController::class,'store']);
Route::middleware('auth:sanctum')->put('/accounts/{id}',[AccountController::class,'update']);
Route::middleware('auth:sanctum')->delete('/accounts/{id}',[AccountController::class,'destroy']);
// Transactons Routes
Route::middleware('auth:sanctum')->get('/transactions',[TransactionController::class,'index']);
Route::middleware('auth:sanctum')->get('/transactions/{id}',[TransactionController::class,'show']);
Route::middleware('auth:sanctum')->post('/transactions',[TransactionController::class,'store']);
Route::middleware('auth:sanctum')->put('/transactions/{id}',[TransactionController::class,'update']);
Route::middleware('auth:sanctum')->delete('/transactions/{id}',[TransactionController::class,'destroy']);
