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
// Short URLS only routes
Route::get('/surl/{uuid}', [\App\Http\Controllers\PublicShortUrlController::class, 'redirectToUrl'])->name('frontend.shorturl');

Route::get('/', function () {
    return view('welcome');
})->name('frontend.home');


Auth::routes();

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->middleware(['hasInvitation'])->name('register');

Route::get('register/request', [\App\Http\Controllers\Auth\RegisterController::class, 'requestInvintation'])->name('frontend.auth.request');
Route::post('invitations', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->middleware('guest')->name('storeInvitation');

// Website Only routes (Guest)
Route::get('/i/{uuid}', [\App\Http\Controllers\PublicImageController::class, 'showImage'])->name('frontend.show.image');


// Account only routes
Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\AccountController::class, 'index'])->name('home');
    Route::get('/settings', [\App\Http\Controllers\User\AccountController::class, 'settings'])->name('user.account.settings');
    Route::get('/api', [\App\Http\Controllers\User\APIController::class, 'index'])->name('user.settings.api');
    Route::get('/upload-settings', [\App\Http\Controllers\User\AccountController::class, 'uploadSettings'])->name('user.upload.settings');

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
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/{userid}/edit/syncroles', [\App\Http\Controllers\Admin\UserController::class, 'assignRoles'])->name('admin.users.sync.roles');
        Route::post('/{userid}/edit/infomration', [\App\Http\Controllers\Admin\UserController::class, 'updateInformation'])->name('admin.users.update.information');
        Route::get('/{userid}/show', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');

        // Delete short url
        Route::get('/shorturl/{id}/delete', [\App\Http\Controllers\Admin\UserController::class, 'deleteShortUrl'])->name('admin.user.del.shorturl');

        // Delete image
        Route::get('/image/{imageId}/delete', [\App\Http\Controllers\Admin\UserController::class, 'deleteImage'])->name('admin.image.delete');
    });


    Route::prefix('acl')->group(function () {
        Route::prefix('permissions')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ACLController::class, 'listPermissions'])->name('admin.list.permissions');
            Route::post('/create', [\App\Http\Controllers\Admin\ACLController::class, 'storePermission'])->name('admin.store.permission');
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ACLController::class, 'listRoles'])->name('admin.list.roles');
            Route::post('/create', [\App\Http\Controllers\Admin\ACLController::class, 'storeRole'])->name('admin.store.role');
            Route::get('/{roleId}/edit', [\App\Http\Controllers\Admin\ACLController::class, 'editRole'])->name('admin.edit.role');
            Route::post('/{roleId}/edit', [\App\Http\Controllers\Admin\ACLController::class, 'updateRole'])->name('admin.update.role');
        });
    });
});
