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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/image/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');

Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');
    Route::get('/api', [\App\Http\Controllers\User\APIController::class, 'index'])->name('user.settings.api');
});
