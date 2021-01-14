<?php
/**
 * Public only routes that DO NOT require authentication of any kind
 */

// Short URLS only routes
Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('frontend.home');

Auth::routes();

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->middleware(['hasInvitation'])->name('register');

Route::get('register/request', [\App\Http\Controllers\Auth\RegisterController::class, 'requestInvintation'])->name('frontend.auth.request');
Route::post('invitations', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('storeInvitation');

// Website Only routes (Guest)
Route::get('/i/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');


Route::group(array('domain' => 's-url.app'), function () {

    Route::get('/', function () {
        return redirect()->away('https://imagefy.me');
    });

    Route::get('/{uuid}', [\App\Http\Controllers\PublicShortUrlController::class, 'redirectToUrl'])->name('frontend.shorturl');

});
