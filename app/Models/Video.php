<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model  implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = ["title","description"];
    public function comments(){

        return $this->morphMany(Comment::class,'commentable');

    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

}
