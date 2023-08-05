<?php

use Pedrazadixon\LaravelSimplePermissions\Controllers\PermissionsController;
use Pedrazadixon\LaravelSimplePermissions\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/permissions/{rol?}', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionsController::class, 'store'])->name('permissions.store');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::get('/roles/edit/{rol}', [RolesController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{rol}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{rol}', [RolesController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::post('/roles/store', [RolesController::class, 'store'])->name('roles.store');
});
