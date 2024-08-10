<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{

     public function __invoke(){

        $activities =ActivityResource::collection( Activity::all());

       
        return Inertia::render('Log/Index',compact('activities'));
     }
}
