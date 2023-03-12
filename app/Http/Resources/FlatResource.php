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
            'room_count'  => $this->room_count,
            'price'       => round($this->price_per_m * $this->area),
            'price_per_m' => $this->price_per_m,
            'currency'    => $this->currency,
            'status'      => $this->status,
            'area'        => $this->area,
            'description' => $this->description,
            'notes'       => $this->notes,
            'type'        => $this->type,
            'project'     => ProjectResource::make($this->whenLoaded('project')),
            'block'       => BlockResource::make($this->whenLoaded('block')),
            'floor'       => FloorResource::make($this->whenLoaded('floor')),
            'plan'        => PlanResource::make($this->whenLoaded('plan')),
            'flats'       => FlatResource::collection($this->whenLoaded('flats')),
            'files'       => FileResource::collection($this->whenLoaded('files')),
            'flats_count' => $this->whenCounted('flats'),
        ];
    }
}
