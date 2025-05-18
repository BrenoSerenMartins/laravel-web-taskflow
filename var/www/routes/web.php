<?php
declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'show'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'show'])->name('user.dashboard');

    Route::put('/boards/{board}/statuses/reorder', [StatusController::class, 'reorder'])->name('boards.statuses.reorder');
    Route::put('/boards/{board}/tasks/reorder', [TaskController::class, 'reorder'])->name('boards.tasks.reorder');

    Route::resource('boards', BoardController::class);
    Route::resource('boards.statuses', StatusController::class);
    Route::resource('boards.tasks', TaskController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});




