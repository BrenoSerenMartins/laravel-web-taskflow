<?php
/**
 * TaskFlow - Task Management System
 *
 * @package TaskFlow
 * @author Breno Seren Martins <brenosm.dev@gmail.com>
 * @license Apache 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @version 1.0
 */

use App\Http\Controllers\BoardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/boards', [BoardController::class, 'index'])->name('boards.index');
Route::post('/board', [BoardController::class, 'store'])->name('board.store');
Route::post('/board/edit', [BoardController::class, 'edit'])->name('board.edit');
Route::delete('/board/delete/{board}', [BoardController::class, 'destroy'])->name('board.destroy');
Route::put('/board/update/{board}', [BoardController::class, 'update'])->name('board.update');



