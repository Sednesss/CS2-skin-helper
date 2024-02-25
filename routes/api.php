<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:api'])->prefix('v1')->as('v1::')->group(function () {
    Route::get('/test', function (Request $request) {
        return [
            'user' => $request->user()
        ];
    })->name('test');

    Route::controller(App\Http\Controllers\API\GameItemController::class)->prefix('game-items')->as('game_items::')->group(function () {
        Route::post('/statusChange', 'statusChange')->name('statusChange');
    });

    Route::controller(App\Http\Controllers\API\SkinController::class)->prefix('skins')->as('skins::')->group(function () {
        Route::post('/pagination', 'pagination')->name('pagination');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');

        Route::post('/import', 'import')->name('import');
    });
});
