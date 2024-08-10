<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id' => $this->id,
            'causer' => $this->causer->name,
            'performed_on' => $this->subject?->name,
            'description' => $this->description,
            'at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
