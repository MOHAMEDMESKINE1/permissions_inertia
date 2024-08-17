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

    // public function registerMediaConversions(?Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Fit::Contain, 300, 300)
    //         ->nonQueued();

    // }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('posts')
            ->singleFile();

       
    }
}
