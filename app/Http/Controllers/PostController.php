<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchQuery = request()->input('search_post');
        if($searchQuery){

            $posts = Post::with(['media','comments','tags'])->where('title', 'like','%'. $searchQuery.'%')->paginate(session('rows',10)); 
        }else{
            $posts = Post::with(['media','comments','tags'])->paginate(session('rows',10));

        }
        $tags = Tag::all();

       return Inertia::render('Admin/Posts/PostIndex',[
            "posts"=> PostResource::collection($posts),
            "tags"=> Inertia::lazy(fn()=> TagResource::collection($tags))
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

        //morph comments
       $post->comments()->create(["body"=>$request->body]);
       
        //morph tags
       $post->tags()->attach($request->tags);

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
        #this is a comment from test branch
        // Validate request data
        $request->validate([
            'title' => ['required'],
            'tags'=> ['array'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:10000']
        ]);

        // Authorize the action
        $this->authorize('update', $post);
        

        // dd($request->tags);
        // Update the post title
        $post->update(['title' => $request->input('title')]);
        
        
        //morph tags
        if ($request->has('tags')) {
            // Convert tag names to tag IDs before syncing
            $tagIds = collect($request->input('tags.*.name'))->map(function ($tagName) {
                // Find the tag by name or create it if it doesn't exist
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });
        
            // Sync the tags to the post (using tag IDs)
            $post->tags()->sync($tagIds);
        }
                
        
        // Update or create the comment associated with the post
        if ($request->filled('body')) {
            // If the post already has a comment, update it; otherwise, create a new one
            if ($post->comments()->exists()) {

                $post->comments()->update([
                    'body' => $request->body
                ]);
            } else {
                $post->comments()->create([
                    'body' => $request->body
                ]);
            }
        }

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

        // morph comments
        $post->comments()->delete();
        //morph tags
        $post->tags()->detach();

        return to_route('posts.index');
    }
}
