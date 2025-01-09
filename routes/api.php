<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\DeviceController;
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
    Route::prefix('/routines')->group(function () {
        Route::get('/all', [RoutineController::class, 'all']);
        Route::get('/{id}', [RoutineController::class, 'show']);
        Route::put('/{routineID}', [RoutineController::class, 'update']);
        Route::patch('/{routineID}/done', [RoutineController::class, 'complete']);
    });
    Route::prefix('/devices')->group(function () {
        Route::post('/', [DeviceController::class, 'store']);
        Route::put('/{deviceID}', [DeviceController::class, 'update']);
        // Route::delete('/{deviceID}', [DeviceController::class, 'destroy']); Future Feature
        Route::post('/{deviceID}/routines', [RoutineController::class, 'store']);
        Route::get('/{deviceID}/routines', [RoutineController::class, 'getRoutines']);
    });
});

?>