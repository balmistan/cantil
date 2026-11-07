<?php

use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

Route::get('/songlist/{id?}', [SongController::class, 'songlist']);
Route::get('/song/{id}', [SongController::class, 'songByID']);
Route::get('/songsheet', [SongController::class, 'songsheet']);

Route::get('/v2/songs', [SongController::class, 'songlist2']);
Route::get('/v2/lyrics/{id?}', [SongController::class, 'lyrics2']);
