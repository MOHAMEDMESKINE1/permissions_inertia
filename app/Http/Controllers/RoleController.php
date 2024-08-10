<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        $searchQuery = request()->input('search_role');
        if($searchQuery){

            $roles = Role::where('name', 'like','%'. $searchQuery.'%')->paginate(session('rows',3)); 
        }else{
            $roles = Role::paginate(session('rows',3));
        }
       
        $permissions =Permission::All();
        return Inertia::render("Admin/Roles/RoleIndex",[
            "roles" => RoleResource::collection($roles)         ,
            "permissions" => PermissionResource::collection($permissions),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
             
         $role = Role::create(["name"=>$request->name]);

         if($request->has('permissions')){
            
            $role->syncPermissions($request->input('permissions.*.name'));
         };

         $user = Auth::user();
         activity()
         ->performedOn($role)
         ->causedBy($user)
         ->log('created role');

        return to_route('roles.index');

         
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
    public function edit(Role $role)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
       $role->update([
        "name" => $request->name
       ]);
       $role->syncPermissions($request->input('permissions.*.name'));
       return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role  $role)
    {
        $role->delete();

       return back();
    }
}
