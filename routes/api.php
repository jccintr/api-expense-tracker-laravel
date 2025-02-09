<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccountController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/login',[AuthController::class,'login']);
// Category Routes
Route::middleware('auth:sanctum')->get('/categories',[CategoryController::class,'index']);
Route::middleware('auth:sanctum')->post('/categories',[CategoryController::class,'store']);
// Account Routes
Route::middleware('auth:sanctum')->get('/accounts',[AccountController::class,'index']);
Route::middleware('auth:sanctum')->post('/accounts',[AccountController::class,'store']);
Route::middleware('auth:sanctum')->put('/accounts/{id}',[AccountController::class,'update']);

