<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RevokePermissionFromRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

// users
Route::resource('/users',UserController::class);

// roles
Route::resource('/roles',RoleController::class);
Route::delete('/roles/{role}/permissions/{permission}',RevokePermissionFromRoleController::class)->name('roles.permissions.destroy');
// permissions
Route::resource('/permissions',PermissionController::class);
