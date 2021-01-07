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
    Route::post('/images/upload', [\App\Http\Controllers\Api\ImageController::class, 'uploadImage']);
});

