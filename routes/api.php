<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;

Route::prefix('applications')->group(function () {
    Route::post('/', [ApplicationController::class, 'store']);
    Route::put('/', [ApplicationController::class, 'update']);
    Route::patch('/', [ApplicationController::class, 'restore']);
    Route::delete('/', [ApplicationController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

?>