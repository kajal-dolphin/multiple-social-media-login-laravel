<?php

use App\Http\Controllers\ApiSocialLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/v1/auth/{driver}/redirect', [ApiSocialLoginController::class, 'redirectToProvider']);
Route::post('/v1/auth/{driver}/callback', [ApiSocialLoginController::class, 'handleProviderCallback']);
Route::post('/logout', [ApiSocialLoginController::class, 'logout'])->middleware('auth:sanctum');
