<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Search\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[AuthController::class,'login'])->middleware('guest')->name('login');

Route::middleware('auth:api')->group(function () {
Route::prefix('search')->name('search.')->group(function (){
    Route::post('book',[BookController::class,'search'])->name('book');
});
});

