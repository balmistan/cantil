<?php

use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/lista');

Route::view('/indice/{id?}', 'indicecanti')->name('indicecanti');
Route::view('/visualizza/{id}', 'visualizza')->name('visualizza');
Route::view('/fogliocanti', 'fogliocanti')->name('fogliocanti');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/lista', 'lista')->name('lista');
    Route::view('/selezione', 'selezione')->name('selezione');
    Route::view('/modifica/{id}', 'modifica')->name('modifica');

    Route::prefix('api')->group(function (): void {
        Route::put('/song/{id}', [SongController::class, 'songUpdate']);
        Route::post('/songschoice', [SongController::class, 'songschoice']);
    });
});
