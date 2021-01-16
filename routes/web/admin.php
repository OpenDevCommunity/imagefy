<?php
/**
 * Administrator only routes that require administrator to be
 */

$adminRoutes = function () {
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

        Route::prefix('errors')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ErrorController::class, 'index'])->name('admin.errors.index');
            Route::get('/{id}/show', [\App\Http\Controllers\Admin\ErrorController::class, 'show'])->name('admin.errors.show');
            Route::get('/{id}/delete', [\App\Http\Controllers\Admin\ErrorController::class, 'delete'])->name('admin.errors.delete');
        });
    });
};


Route::group(['domain' => 'imagefy.me'], $adminRoutes);

if (env('APP_DEBUG')) {
    Route::group(['domain' => 'localhost'], $adminRoutes);
}
