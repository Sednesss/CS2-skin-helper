<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware([])->prefix('admin-panel')->as('admin_panel::')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminPanel\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(App\Http\Controllers\AdminPanel\GameItemController::class)->prefix('game-items')->as('game_items::')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{gameItem}', 'show')->name('show');
        Route::delete('/{gameItem}', 'destroy')->name('destroy');
    });
    
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
