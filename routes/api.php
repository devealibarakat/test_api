<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'prefix' => 'auth'
], function () {


    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('logout',   [AuthController::class, 'logout']);
    Route::get('users',     [AuthController::class, 'userList']);
    Route::get('profile',   [AuthController::class, 'userProfile']);
    Route::put('profile',   [AuthController::class, 'updateProfile']);
    Route::delete('profile',[AuthController::class, 'destroy']);
});
