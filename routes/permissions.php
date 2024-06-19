<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RevokePermissionFromUser;

use App\Http\Controllers\RemoveRoleFromUserController;
use App\Http\Controllers\RevokePermissionFromRoleController;

// Route::middleware(['auth','role:admin'])->group(function(){
    
    // users
    Route::resource('/users',UserController::class);
  
    // roles
    Route::resource('/roles',RoleController::class);
 
    
    // permissions
    Route::resource('/permissions',PermissionController::class);
   
    Route::delete('/roles/{role}/permissions/{permission}', RevokePermissionFromRoleController::class)
        ->name('roles.permissions.destroy');

    Route::delete('/users/{user}/permissions/{permission}', RevokePermissionFromUser::class)
        ->name('users.permissions.destroy');
        
    Route::delete('/users/{user}/roles/{role}', RemoveRoleFromUserController::class)
        ->name('users.roles.destroy');


// });


