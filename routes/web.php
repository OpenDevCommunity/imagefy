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
})->name('frontend.home');


Auth::routes();

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->middleware(['hasInvitation'])->name('register');

Route::get('register/request', [\App\Http\Controllers\Auth\RegisterController::class, 'requestInvintation'])->name('frontend.auth.request');
Route::post('invitations', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('storeInvitation');

// Website Only routes (Guest)
Route::get('/image/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');

// Short URLS only routes
Route::get('/surl/{uuid}', [\App\Http\Controllers\PublicShortUrlController::class, 'redirectToUrl'])->name('frontend.shorturl');

// Account only routes
Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');
    Route::get('/settings', [\App\Http\Controllers\User\AccountController::class, 'settings'])->name('user.account.settings');
    Route::get('/api', [\App\Http\Controllers\User\APIController::class, 'index'])->name('user.settings.api');

    Route::prefix('images')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ImageController::class, 'index'])->name('user.image.library');
        Route::get('/{uuid}/delete', [\App\Http\Controllers\User\ImageController::class, 'deleteImage'])->name('user.image.delete');
        Route::get('/{uuid}/edit', [\App\Http\Controllers\User\ImageController::class, 'imageSettings'])->name('user.image.settings');
        Route::post('/{id}/tempurl', [\App\Http\Controllers\User\ImageController::class, 'generateTemporaryUrl'])->name('user.images.temp');

        // Image Settings
        Route::post('/{id}/visibility', [\App\Http\Controllers\User\ImageController::class, 'setImageVisibility'])->name('user.image.settings.visibility');
    });

    Route::prefix('shorturls')->group(function () {
         Route::get('/', [\App\Http\Controllers\User\ShortUrlController::class, 'index'])->name('user.short.urls');
    });
});


// Administration routes only
Route::prefix('admin')->middleware(['auth', 'role:administrator|superadministrator'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('invites')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\InviteController::class, 'index'])->name('admin.invites.pending');
        Route::post('/store', [\App\Http\Controllers\Admin\InviteController::class, 'store'])->name('admin.invites.store');
        Route::get('/{id}/accept', [\App\Http\Controllers\Admin\InviteController::class, 'acceptInvite'])->name('admin.invites.accept');
        Route::get('/{id}/reject', [\App\Http\Controllers\Admin\InviteController::class, 'denyInvite'])->name('admin.invites.deny');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users.index');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin.users.edit');
        Route::post('/{userid}/edit/syncroles', [\App\Http\Controllers\Admin\UsersController::class, 'assignRoles'])->name('admin.users.sync.roles');
        Route::post('/{userid}/edit/infomration', [\App\Http\Controllers\Admin\UsersController::class, 'updateInformation'])->name('admin.users.update.information');
        Route::get('/{userid}/show', [\App\Http\Controllers\Admin\UsersController::class, 'show'])->name('admin.users.show');
    });
});

