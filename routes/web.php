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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/cars', [App\Http\Controllers\HomeController::class, 'index_cars'])->name('cars');

Route::get('/revisions', [App\Http\Controllers\HomeController::class, 'index_revisions'])->name('revisions');

Route::get('/car-register/{owner_id}', [App\Http\Controllers\HomeController::class, 'index_car'])->name('car-register');

Route::get('/revision-register/{vehicle_id}', [App\Http\Controllers\HomeController::class, 'index_revision'])->name('revision-register');