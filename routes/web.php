<?php

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

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->middleware(['hasInvitation'])->name('register');

Route::get('register/request', [\App\Http\Controllers\Auth\RegisterController::class, 'requestInvintation'])->name('frontend.auth.request');
Route::post('invitations', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('storeInvitation');



// Website Only routes (Guest)
Route::get('/image/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');

// Account only routes
Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');
    Route::get('/api', [\App\Http\Controllers\User\APIController::class, 'index'])->name('user.settings.api');

    Route::prefix('images')->group(function () {
        Route::get('/{uuid}/delete', [\App\Http\Controllers\User\AccountController::class, 'deleteImage'])->name('user.image.delete');
    });
});

