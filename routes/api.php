<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ClientesController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){//argrupando por controller 
    Route::post('/auth/register', 'createUser');
    Route::post('/auth/login', 'loginUser');
});

Route::apiResource('product', ProductController::class)->middleware('auth:sanctum');
//Route::post('product/{param}', ProductController::class@teste')->middleware('auth:sanctum');
Route::apiResource('cliente', ClientesController::class)->middleware('auth:sanctum');

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'createUser']);
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);

Route::apiResource('posts', App\Http\Controllers\Api\PostController::class)->middleware('auth:sanctum');
*/