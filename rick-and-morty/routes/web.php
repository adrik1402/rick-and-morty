<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/characters/{page?}', [ App\Http\Controllers\CharacterController::class, 'index'])->name('characters.index');
Route::get('/favoritos', [App\Http\Controllers\CharacterController::class, 'getFavoritos'])->name('favoritos');

Route::post('/addCharacter', [ App\Http\Controllers\CharacterController::class, 'addCharacter'])->name('characters.add');
Route::post('/deleteCharacter', [ App\Http\Controllers\CharacterController::class, 'deleteCharacter'])->name('characters.delete');

