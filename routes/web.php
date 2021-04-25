<?php

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
Route::get('/file/{file}', [\App\Http\Controllers\DocumentController::class, 'file'])->name('document-file');

Route::get('/{document}', [\App\Http\Controllers\DocumentController::class, 'index'])->name('document.index');
Route::post('/{document}', [\App\Http\Controllers\DocumentController::class, 'update'])->name('document.update');

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
