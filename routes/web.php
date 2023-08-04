<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdventureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
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

    Route::name('api.')->group(function () {
        Route::prefix('adventures')->group(function () {
            Route::put('/{adventureId}/{contentId}/save', [AdventureController::class, 'save'])->name('adventures.save');
        });

        Route::prefix('options')->group(function () {
            Route::post('/{contentId}/{optionId}/save', [OptionController::class, 'save'])->name('options.save');
        });

        Route::prefix('contents')->group(function () {
            Route::post('/{adventureId}/{contentId}', [ContentController::class, 'save'])->name('contents.save');
            Route::delete('/{adventureId}/{contentId}', [ContentController::class, 'delete'])->name('contents.delete');
        });
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/adventures', [AdminController::class, 'adventures'])->name('adventures');
    Route::get('/adventures/edit/{slug}', [AdminController::class, 'adventure'])->name('adventures.edit');
});
