<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\SocialLoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/social-login', function () {
    return view('social-login');
})->name('social-login');


Route::get('/auth/{driver}',[SocialLoginController::class,'redirectToProvider']);
Route::get('/auth/{driver}/callback',[SocialLoginController::class,'handlProviderCallback']);

Route::post('/logout', [SocialLoginController::class, 'logout'])->name('logout');
