<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;

Route::post('/applications', [ApplicationController::class, 'store']); // For generating credentials

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('/applications')->group(function () {
        Route::put('/', [ApplicationController::class, 'update']);
        Route::delete('/', [ApplicationController::class, 'destroy']);
        Route::patch('/', [ApplicationController::class, 'regenerateSecret']);
    });
});

?>