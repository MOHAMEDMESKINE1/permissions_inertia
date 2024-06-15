<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Rules\Password;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

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
            'search_user' => $searchQuery
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create');
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

        return to_route('users.index');

         
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
        return Inertia::render("Admin/Users/Edit",[
            "user" => new UserResource($user)
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
