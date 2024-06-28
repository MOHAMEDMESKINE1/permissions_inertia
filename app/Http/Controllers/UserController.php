<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PermissionResource;
 use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        $searchQuery = request()->input('search_user');
        if($searchQuery){

            $users = User::where('name', 'like','%'. $searchQuery.'%')->get(); 
        }else{
            $users = User::all();
        }
       
        return Inertia::render("Admin/Users/UserIndex",[
            "users" => UserResource::collection($users)         ,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $permissions =Permission::all();
        $roles =Role::all();

        return Inertia::render('Admin/Users/Create',[
            "permissions" => PermissionResource::collection($permissions),
            "roles" => RoleResource::collection($roles),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    { 
        $user->load(['roles','permissions']);
        $permissions =Permission::all();
        $roles =Role::all();

       
        return Inertia::render("Admin/Users/Edit",[
            "user" => new UserResource($user),
            "permissions" => PermissionResource::collection($permissions),
            "roles" => RoleResource::collection($roles),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Get validated data
        $data = $request->validated();
    
        // Check if password is present in the request and hash it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        // Update the user with the combined data
        $user->update($data);

        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User  $user)
    {
        $user->delete();

       return back();
    }
}
