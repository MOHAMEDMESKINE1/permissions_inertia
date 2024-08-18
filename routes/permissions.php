<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminConTroller;
use App\Http\Controllers\Log\ActivityLogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RevokePermissionFromUser;
use App\Http\Controllers\RemoveRoleFromUserController;
use App\Http\Controllers\RevokePermissionFromRoleController;
use App\Http\Controllers\VideoController;
use Laravel\Telescope\Http\Controllers\LogController;

Route::middleware(['auth','role:admin'])
->prefix('/admin/pages/')
->group(function(){

     // posts
    Route::resource('posts',PostController::class)->middleware(['auth','role:admin|moderator|user']);
    
    // videos
    Route::resource('videos',VideoController::class)->middleware(['auth','role:admin|moderator|user']);

    Route::get('log',ActivityLogController::class)->name('log.index');
    Route::get('admin', [AdminConTroller::class, 'index'])->name('admin.index');

   
    // users
    Route::resource('users',UserController::class);
  
    // roles
    Route::resource('roles',RoleController::class);
 
    
    // permissions
    Route::resource('permissions',PermissionController::class);
   
    Route::delete('roles/{role}/permissions/{permission}', RevokePermissionFromRoleController::class)
        ->name('roles.permissions.destroy');

    Route::delete('users/{user}/permissions/{permission}', RevokePermissionFromUser::class)
        ->name('users.permissions.destroy');
        
    Route::delete('users/{user}/roles/{role}', RemoveRoleFromUserController::class)
        ->name('users.roles.destroy');


});


 Route::post('set/rows', function (Request $request) {

    session()->put('rows', $request->rows);
    return redirect()->back();
})->name("set.rows")->middleware(['auth','role:admin|moderator|user']);;

