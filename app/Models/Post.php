<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model  implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = ["title"];

 
    public function comments(){

        return $this->morphMany(Comment::class,'commentable');

    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
