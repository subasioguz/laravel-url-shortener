<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
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

// Authenticate
Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
    });

// Links
Route::controller(LinkController::class)
    ->prefix('links')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/', 'index')->name('links');
        Route::get('/{id}', 'show')->name('links.show');
        Route::post('/', 'create')->name('links.create');
        Route::put('/{id}', 'update')->name('links.update');
        Route::delete('/{id}', 'delete')->name('links.delete');
    });
