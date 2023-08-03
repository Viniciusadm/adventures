<?php

use App\Http\Controllers\AdventureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SiteController;
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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logar', [AuthController::class, 'logar'])->name('logar');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('home');
    Route::get('/play/{slug}', [SiteController::class, 'play'])->name('play');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('adventures')->group(function () {
        Route::put('/{adventureId}/{contentId}/save', [AdventureController::class, 'save'])->name('api.adventures.save');
    });

    Route::prefix('options')->group(function () {
        Route::post('/{contentId}/{optionId}/save', [OptionController::class, 'save'])->name('api.options.save');
    });
});
