<?php


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


Route::prefix('v1')->middleware(['apikey'])->group(function () {

    Route::prefix('images')->group(function () {
        Route::post('/upload', [\App\Http\Controllers\Api\ImageController::class, 'uploadImage'])->middleware(['canWrite']);
        Route::post('/{id}/setvisibility', [\App\Http\Controllers\Api\ImageController::class, 'setImageVisibility'])->middleware(['canWrite']);
        Route::delete('/{uuid}', [\App\Http\Controllers\Api\ImageController::class, 'deleteImage'])->middleware(['canWrite']);
    });

    Route::prefix('shorturl')->group(function () {
        Route::get('/all', [\App\Http\Controllers\Api\ShortURLController::class, 'fetchAllShortUrls'])->middleware(['canRead']);
        Route::post('/create', [\App\Http\Controllers\Api\ShortURLController::class, 'createShortURL'])->middleware(['canWrite']);
    });
});


Route::prefix('internal-user')->middleware(['api:auth'])->group(function () {
    //
});
