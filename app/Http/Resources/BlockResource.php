<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
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
            'flats'       => FlatResource::collection($this->whenLoaded('flats')),
            'files'       => FileResource::collection($this->whenLoaded('files')),
            'flats_count' => $this->whenCounted('flats'),
        ];
    }
}
