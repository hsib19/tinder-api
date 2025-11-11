<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/dev/token', function () {
    $user = \App\Models\User::find(1); 
    $token = $user->createToken('dev-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth.json')->group(function () {
    Route::get('/recommendations', [UserController::class, 'recommendations']);
    Route::post('/users/{user}/like', [UserController::class, 'like']);
    Route::post('/users/{user}/dislike', [UserController::class, 'dislike']);
    Route::get('/users/liked', [UserController::class, 'liked']);
});
