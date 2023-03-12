<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['blocks.flats']);
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'address'               => $this->address,
            'start_date'            => $this->start_date,
            'estimated_finish_date' => $this->estimated_finish_date,
            'project_details'       => $this->project_details,
            'blocks'                => BlockBoardResource::collection($this->blocks),
        ];
    }
}
