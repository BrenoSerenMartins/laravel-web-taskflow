<?php
/**
 * TaskFlow - Task Management System
 *
 * @package TaskFlow
 * @author Breno Seren Martins <brenosm.dev@gmail.com>
 * @license Apache 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @version 1.0
 */

use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('boards', BoardController::class);
Route::resource('boards.statuses', StatusController::class);




