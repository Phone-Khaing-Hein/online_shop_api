<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['cors'])->prefix("v1")->group(function(){
    Route::post("register", [\App\Http\Controllers\AuthApiController::class,"register"])->name("api.register");
    Route::post("login", [\App\Http\Controllers\AuthApiController::class, "login"])->name("api.login");

    Route::middleware("auth:sanctum")->group(function(){
        Route::post("logout", [\App\Http\Controllers\AuthApiController::class,"logout"])->name("api.logout");
        Route::post("logout-all", [\App\Http\Controllers\AuthApiController::class, "logoutAll"])->name("api.logoutAll");
        Route::get("tokens", [\App\Http\Controllers\AuthApiController::class, "tokens"])->name("api.tokens");
        Route::apiResource("products", \App\Http\Controllers\ProductApiController::class);
        Route::apiResource("photos", \App\Http\Controllers\PhotoApiController::class);
    });
});

