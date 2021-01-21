<?php
/**
 * User routes only that require user to be authenticated
 */

$userRoutes = function () {
    // Account only routes
    Route::prefix('account')->middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');

        // Settings Routes
        Route::prefix('settings')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\AccountController::class, 'showSettingsPage'])->name('account.settings');

            // API Routes
            Route::prefix('api')->group(function () {
                Route::get('/', [\App\Http\Controllers\User\APIController::class, 'index'])->name('api.settings');
                Route::get('/{id}/edit', [\App\Http\Controllers\User\APIController::class, 'showAPISettings'])->name('api.configuration');
                Route::post('/{id}/edit', [\App\Http\Controllers\User\APIController::class, 'updateAPISettings'])->name('api.settings.update');
                Route::get('/{id}/{type}/sharex', [\App\Http\Controllers\User\APIController::class, 'generateSharexFile'])->name('sharex.config.download');
            });
        });

        // Account library routes
        Route::prefix('library')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ImageController::class, 'index'])->name('library');
            Route::get('/{uuid}/edit', [\App\Http\Controllers\User\ImageController::class, 'imageSettings'])->name('library.image.settings');
            Route::post('/{id}/tempurl', [\App\Http\Controllers\User\ImageController::class, 'generateTemporaryUrl'])->name('library.image.tempurl');
            Route::post('/{id}/visibility', [\App\Http\Controllers\User\ImageController::class, 'setImageVisibility'])->name('library.image.setvisibility');
            Route::get('/{uuid}/delete', [\App\Http\Controllers\User\ImageController::class, 'deleteImage'])->name('library.image.destroy');
        });

        // Account upload settings
        Route::prefix('upload-settings')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\AccountController::class, 'showUploadSettingsPage'])->name('upload.settings');
            Route::post('/{id}/default-visibility', [\App\Http\Controllers\User\SettingController::class, 'setDefaultImageVisibility'])->name('set.default.visibility');
        });

        // Account short URL routes
        Route::prefix('shorturls')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\ShortUrlController::class, 'index'])->name('short.urls');
        });
    });
};


// Register routes for imagefy.me domain
Route::group(['domain' => parse_url(config('app.url'))['host']], $userRoutes);

// Register localhost routes when in debug mode
if (env('APP_DEBUG')) {
    Route::group(['domain' => 'localhost'], $userRoutes);
}
