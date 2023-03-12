<?php

namespace App\Http\Resources;

use App\Enum\FlatStatus;
use App\Enum\FlatType;
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
            'price'       => round($this->price_per_m * $this->area, 2),
            'price_per_m' => $this->price_per_m,
            'currency'    => $this->currency,
            'status'      => $this->status ?? FlatStatus::FREE,
            'area'        => $this->area,
            'notes'       => $this->notes,
            'type'        => $this->type,
            'section'     => (string)$this->section,
            'floor'       => (string)$this->floor,
            'project'     => ProjectResource::make($this->whenLoaded('project')),
            'block'       => BlockResource::make($this->whenLoaded('block')),
            'plan'        => PlanResource::make($this->whenLoaded('plan')),
            'files'       => FileResource::collection($this->whenLoaded('files')),
        ];
    }
}
