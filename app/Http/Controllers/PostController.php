<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchQuery = request()->input('search_post');
        if($searchQuery){

            $posts = Post::with('media')->where('title', 'like','%'. $searchQuery.'%')->paginate(session('rows',10)); 
        }else{
            $posts = Post::with('media')->paginate(session('rows',10));

        }
        
       

       return Inertia::render('Admin/Posts/PostIndex',[
            "posts"=> PostResource::collection($posts)
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Post::class);
        return Inertia::render('Admin/Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create',Post::class);
        
       $post =  Post::create($request->validated());

       if($post){
        $post->addMediaFromRequest('image')->toMediaCollection('posts');
       }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {       $this->authorize('update',$post);
            return Inertia::render('Admin/Posts/Edit',
    
                ["post" => new PostResource($post)]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    { 
         
       // Validate request data
        $request->validate([
            'title' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:10000']
        ]);

        // Authorize the action
        $this->authorize('update', $post);

        // Update the post title
        $post->update(['title' => $request->input('title')]);

        // Handle the image if it's present in the request
        if ($request->hasFile('image')) {
            // Clear any existing media before adding new one
            $post->clearMediaCollection('posts');

            // Add the new image to the media collection
            $post->addMediaFromRequest('image')->toMediaCollection('posts');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);
        $post->delete();
        
        return to_route('posts.index');
    }
}
