<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VideoResource;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchQuery = request()->input('search_video');
        if($searchQuery){

            $videos =Video::with(['media','comments'])
            ->where('title', 'like','%'. $searchQuery.'%')
            ->orWhere('description', 'like','%'. $searchQuery.'%')
            ->paginate(session('rows',10)); 
        }else{
            
            $videos =Video::with(['media','comments'])->paginate(session('rows',10));

        }
        
       

       return Inertia::render('Admin/Videos/VideoIndex',[
            "videos"=> VideoResource::collection($videos)
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create',video::class);
        // return Inertia::render('Admin/Videos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate request data
         $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'video' => ['required' ,'mimes:mp4,mov,ogg,qt','max:20000']
        ]);

        $this->authorize('create',Video::class);
        
       $video = Video::create($request->only('title','description','video'));
       
       $video->comments()->create(["body"=>$request->body]);

       if($video){
        $video->addMediaFromRequest('video')->toMediaCollection('videos');
       }
       $user = Auth::user();
       activity()
       ->performedOn($video)
       ->causedBy($user)
       ->log('created video');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {       
        // $this->authorize('update',$video);
        //     return Inertia::render('Admin/Videos/Edit',
    
        //         ["video" => new VideoResource($video)]
        // );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    { 
         
       // Validate request data
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'video' => ['nullable' ,'mimes:mp4,mov,ogg,qt','max:20000']
        ]);

        // Authorize the action
        $this->authorize('update', $video);

        // Update the video title
        $video->update(
            [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                
            ]
        );

        // Update or create the comment associated with the post
        if ($request->filled('body')) {
            // If the post already has a comment, update it; otherwise, create a new one
            if ($video->comments()->exists()) {

                $video->comments()->update([
                    'body' => $request->body
                ]);
            } else {
                $video->comments()->create([
                    'body' => $request->body
                ]);
            }
        }
        // Handle the image if it's present in the request
        if ($request->hasFile('video')) {
            // Clear any existing media before adding new one
            $video->clearMediaCollection('videos');

            // Add the new image to the media collection
            $video->addMediaFromRequest('video')->toMediaCollection('videos');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->authorize('delete',$video);
        $video->delete();
        
        return to_route('videos.index');
    }
}
