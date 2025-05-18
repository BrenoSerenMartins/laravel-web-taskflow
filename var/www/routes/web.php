<?php
declare(strict_types=1);

use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::put('/boards/{board}/statuses/reorder', [StatusController::class, 'reorder'])->name('boards.statuses.reorder');
Route::put('/boards/{board}/tasks/reorder', [TaskController::class, 'reorder'])->name('boards.tasks.reorder');


Route::resource('boards', BoardController::class);
Route::resource('boards.statuses', StatusController::class);
Route::resource('boards.tasks', TaskController::class);




