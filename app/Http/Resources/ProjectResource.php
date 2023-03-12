<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'address'               => $this->address,
            'start_date'            => $this->start_date,
            'estimated_finish_date' => $this->estimated_finish_date,
            'project_details'       => $this->project_details,
            'blocks'                => BlockResource::collection($this->whenLoaded('blocks')),
            'flats'                 => FlatResource::collection($this->whenLoaded('flats')),
            'files'                 => FileResource::collection($this->whenLoaded('files')),
            'blocks_count'          => $this->whenCounted('blocks'),
            'flats_count'           => $this->whenCounted('flats'),
        ];


    }


}
