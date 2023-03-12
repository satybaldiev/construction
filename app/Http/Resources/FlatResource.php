<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlatResource extends JsonResource
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
            'floor'       => FloorResource::make($this->whenLoaded('floor')),
            'plan'       => PlanResource::make($this->whenLoaded('plan')),
            'flats'       => FlatResource::collection($this->whenLoaded('flats')),
            'files'       => FileResource::collection($this->whenLoaded('files')),
            'flats_count' => $this->whenCounted('flats'),
        ];
    }
}
