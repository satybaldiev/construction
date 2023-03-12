<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'project'     => ProjectResource::make($this->whenLoaded('project')),
            'flats'       => FlatResource::collection($this->whenLoaded('flats')),
            'flats_count' => $this->whenCounted('flats'),
            'files'       => FileResource::collection($this->whenLoaded('files')),
        ];
    }
}
