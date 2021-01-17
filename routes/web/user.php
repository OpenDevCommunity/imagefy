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

        // Account library functions
        Route::prefix('images')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ImageController::class, 'index'])->name('user.image.library');
            Route::get('/{uuid}/delete', [\App\Http\Controllers\User\ImageController::class, 'deleteImage'])->name('user.image.delete');
            Route::get('/{uuid}/edit', [\App\Http\Controllers\User\ImageController::class, 'imageSettings'])->name('user.image.settings');
            Route::post('/{id}/tempurl', [\App\Http\Controllers\User\ImageController::class, 'generateTemporaryUrl'])->name('user.images.temp');
            Route::post('/{id}/visibility', [\App\Http\Controllers\User\ImageController::class, 'setImageVisibility'])->name('user.image.settings.visibility');
        });

        // Account upload settings
        Route::prefix('upload-settings')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\AccountController::class, 'showUploadSettingsPage'])->name('user.upload.settings');
            Route::post('/{id}/default-visibility', [\App\Http\Controllers\User\SettingController::class, 'setDefaultImageVisibility'])->name('user.upload.settings.visibility');
        });

        // Account short URL routes
        Route::prefix('shorturls')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ShortUrlController::class, 'index'])->name('user.short.urls');
        });
    });
};


// Register routes for imagefy.me domain
Route::group(['domain' => 'imagefy.me'], $userRoutes);

// Register localhost routes when in debug mode
if (env('APP_DEBUG')) {
    Route::group(['domain' => 'localhost'], $userRoutes);
}
