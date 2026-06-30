<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LiveDrawController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\WinnerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/live-draw');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/live-draw', [LiveDrawController::class, 'index'])->name('live-draw');
    Route::get('/live-system', [LiveDrawController::class, 'liveSystem'])->name('live-system');
    Route::post('/live-draw/winners', [LiveDrawController::class, 'storeWinner'])->name('live-draw.winners.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes.index');
    Route::post('/prizes', [PrizeController::class, 'store'])->name('prizes.store');
    Route::delete('/prizes/{prize}', [PrizeController::class, 'destroy'])->name('prizes.destroy');
    Route::get('/winners', [WinnerController::class, 'index'])->name('winners');
    Route::delete('/winners/{winner}', [WinnerController::class, 'destroy'])->name('winners.destroy');
    Route::post('/participants', [DashboardController::class, 'store'])->name('participants.store');
    Route::post('/participants/import', [DashboardController::class, 'import'])->name('participants.import');
    Route::post('/participants/import-stream', [DashboardController::class, 'importStream'])->name('participants.import-stream');
    Route::delete('/participants/{participant}', [DashboardController::class, 'destroy'])->name('participants.destroy');
    Route::delete('/participants', [DashboardController::class, 'destroyAll'])->name('participants.destroy-all');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
