<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchQuery = request()->input('search_tag');
        if($searchQuery){

            $tags =Tag::with(['videos','posts'])
            ->where('name', 'like','%'. $searchQuery.'%')
            ->paginate(session('rows',10)); 
        }else{
            
            $tags =Tag::with(['videos','posts'])->paginate(session('rows',10));

        }
        return Inertia::render('Admin/Tags/TagIndex',[
            "tags"=> TagResource::collection($tags)
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','max:255']
        ]);
        Tag::create($request->only("name"));

        return redirect()->back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            
            'name'=>['required','string','max:255']
        ]);

        $tag->update( $request->only('name'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag) 
    {
        $tag->delete();

        return redirect()->back();
    }
}
