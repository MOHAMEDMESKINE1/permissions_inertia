<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        $searchQuery = request()->input('search_permission');
        if($searchQuery){

            $permissions = Permission::where('name', 'like','%'. $searchQuery.'%')->get(); 
        }else{
            $permissions = Permission::all();
        }
       
        return Inertia::render("Admin/Permissions/PermissionIndex",[
            "permissions" => PermissionResource::collection($permissions),
            'search_permission' => $searchQuery
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Permissions/Create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
             
         Permission::create($request->validated());

        return to_route('permissions.index');

         
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
    public function edit(Permission $permission)
    
    {
        return Inertia::render("Admin/Permissions/Edit",[
            "permission" => new PermissionResource($permission)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
       $permission->update($request->validated());

       return to_route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission  $permission)
    {
        $permission->delete();

       return back();
    }

}
