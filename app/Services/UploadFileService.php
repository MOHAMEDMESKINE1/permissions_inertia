<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
 
class UploadFileService
{
    public function uploadFile(Model $model,$file, $collectionName)
    {
       $media =  $model->addMediaFromRequest( $file)->toMediaCollection($collectionName);

      return $media ; 
    
    }
}