<?php
/**
 * Public only routes that DO NOT require authentication of any kind
 */

$publicRoutes = function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('frontend.home');

    Auth::routes();

    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->middleware(['hasInvitation'])->name('register');

    Route::get('register/request', [\App\Http\Controllers\Auth\RegisterController::class, 'requestInvintation'])->name('frontend.auth.request');
    Route::post('invitations', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('frontend.store.request');

    Route::get('/lang/{lang}', [\App\Http\Controllers\PageController::class, 'setLanguage'])->name('frontend.setlang');

    // Website Only routes (Guest)
    Route::get('/i/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');
};

$shortRoutes = function () {
    Route::get('/', function () {
        return redirect()->away('https://imagefy.me');
    });

    Route::get('/{uuid}', [\App\Http\Controllers\PublicShortUrlController::class, 'redirectToUrl'])->name('frontend.shorturl');
};


Route::group(['domain' => parse_url(config('app.url'))['host']], $publicRoutes);

if (env('APP_DEBUG')) {
    Route::group(['domain' => 'localhost'], $publicRoutes);
    Route::group(['domain' => 'short.localhost'], $shortRoutes);
}

if (config('app.short_url_enabled')) {
    Route::group(['domain' => parse_url(config('app.short_url'))['host']], $shortRoutes);
}
