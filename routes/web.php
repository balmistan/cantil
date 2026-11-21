<?php

use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::view('/indice/{id?}', 'indicecanti')->name('indicecanti');
Route::view('/visualizza/{id}', 'visualizza')->name('visualizza');
Route::view('/fogliocanti', 'fogliocanti')->name('fogliocanti');

Route::middleware(['auth'])->group(function (): void {

    Route::get('/', function () {
        return redirect()->route('lista');
    });

    Route::view('/lista', 'lista')->name('lista');
    Route::view('/selezione', 'selezione')->name('selezione');
    Route::view('/modifica/{id}', 'modifica')->name('modifica');

    Route::prefix('api')->group(function (): void {
        Route::put('/song/{id}', [SongController::class, 'songUpdate']);
        Route::post('/songschoice', [SongController::class, 'songschoice']);
    });
});

