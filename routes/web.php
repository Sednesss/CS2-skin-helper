<?php

use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth', 'user.role.owner'])->prefix('admin-panel')->as('admin_panel::')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminPanel\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(App\Http\Controllers\AdminPanel\GameItemController::class)->prefix('game-items')->as('game_items::')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{gameItem}', 'show')->name('show');
        Route::get('/{gameItem}/edit', 'edit')->name('edit');
        Route::post('/{gameItem}', 'update')->name('update');
        Route::delete('/{gameItem}', 'destroy')->name('destroy');
    });

    Route::controller(App\Http\Controllers\AdminPanel\SkinController::class)->prefix('skins')->as('skins::')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

