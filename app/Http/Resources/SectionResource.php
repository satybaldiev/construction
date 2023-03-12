<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'project'     => ProjectResource::make($this->whenLoaded('project')),
            'block'       => BlockResource::make($this->whenLoaded('block')),
            'floors'      => FloorResource::collection($this->whenLoaded('floors')),
            'flats'       => FlatResource::collection($this->whenLoaded('flats')),
            'flats_count' => $this->whenCounted('flats'),
        ];
    }
}
