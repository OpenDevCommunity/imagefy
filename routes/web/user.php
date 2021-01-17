<?php
/**
 * User routes only that require user to be authenticated
 */

$userRoutes = function () {
    // Account only routes
    Route::prefix('account')->middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');
        Route::get('/settings', [\App\Http\Controllers\User\AccountController::class, 'showSettingsPage'])->name('user.account.settings');
        Route::get('/api', [\App\Http\Controllers\User\APIController::class, 'index'])->name('user.settings.api');
        Route::get('/api/{id}/{type}/sharex', [\App\Http\Controllers\User\APIController::class, 'generateSharexFile'])->name('user.api.sharex');
        Route::get('/upload-settings', [\App\Http\Controllers\User\AccountController::class, 'showUploadSettingsPage'])->name('user.upload.settings');

        Route::prefix('images')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ImageController::class, 'index'])->name('user.image.library');
            Route::get('/{uuid}/delete', [\App\Http\Controllers\User\ImageController::class, 'deleteImage'])->name('user.image.delete');
            Route::get('/{uuid}/edit', [\App\Http\Controllers\User\ImageController::class, 'imageSettings'])->name('user.image.settings');
            Route::post('/{id}/tempurl', [\App\Http\Controllers\User\ImageController::class, 'generateTemporaryUrl'])->name('user.images.temp');

            // Image Settings
            Route::post('/{id}/visibility', [\App\Http\Controllers\User\ImageController::class, 'setImageVisibility'])->name('user.image.settings.visibility');
        });

        Route::prefix('upload-settings')->group(function () {
            Route::post('/{id}/default-visibility', [\App\Http\Controllers\User\SettingController::class, 'setDefaultImageVisibility'])->name('user.upload.settings.visibility');
        });

        Route::prefix('shorturls')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ShortUrlController::class, 'index'])->name('user.short.urls');
        });
    });
};



Route::group(['domain' => 'imagefy.me'], $userRoutes);

if (env('APP_DEBUG')) {
    Route::group(['domain' => 'localhost'], $userRoutes);
}
