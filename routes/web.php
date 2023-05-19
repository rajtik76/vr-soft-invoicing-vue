<?php

use App\Http\Controllers\Grid\TaskSpentTimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return to_route('login');
});

// Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth + verified
Route::middleware(['auth', 'verified'])->group(function () {

    // Task
    Route::resource('/task', TaskController::class);
    Route::post('/task/toggle-active', [TaskController::class, 'toggleActive'])->name('task.toggle-active');

    // Time
    Route::resource('/time', TimeController::class)->except(['show']);

    // Grids
    Route::prefix('/grid')->name('grid.')->group(function () {

        // Time log grid
        Route::post('/time', TaskSpentTimeController::class)->name('time');
        // Task grid
        Route::post('/task', \App\Http\Controllers\Grid\TaskController::class)->name('task');

    });

});

require __DIR__ . '/auth.php';
