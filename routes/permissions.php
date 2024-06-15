<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

// users
Route::resource('/users',UserController::class);

// roles
Route::resource('/roles',RoleController::class);

// permissions
Route::resource('/permissions',PermissionController::class);
