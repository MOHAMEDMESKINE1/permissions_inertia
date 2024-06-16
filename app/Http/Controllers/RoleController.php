<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
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

            $roles = Role::where('name', 'like','%'. $searchQuery.'%')->get(); 
        }else{
            $roles = Role::all();
        }
       
        return Inertia::render("Admin/Roles/RoleIndex",[
            "roles" => RoleResource::collection($roles)         ,
            'search_role' => $searchQuery
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Admin/Roles/Create',[
            "permissions" =>PermissionResource::collection($permissions),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
             
         $role = Role::create(["name"=>$request->name]);

         if($request->has('permissions')){
            
            $role->syncPermissions($request->input('permissions.*.name'));
         }

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
        $permissions = Permission::all();
        $role->load('permissions');

        return Inertia::render("Admin/Roles/Edit",[
            "role" => new RoleResource($role),
            "permissions" =>PermissionResource::collection($permissions),
        ]);
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
