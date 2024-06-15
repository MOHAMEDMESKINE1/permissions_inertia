<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;

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
        return Inertia::render('Admin/Roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
             
         Role::create($request->validated());

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
        return Inertia::render("Admin/Roles/Edit",[
            "role" => new RoleResource($role)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
       $role->update($request->validated());

       return to_route('roles.index');
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
