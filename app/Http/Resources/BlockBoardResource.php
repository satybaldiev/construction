<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['flats']);
        return [
            'id'         => $this->id,
            'block_name' => $this->block_name,
            'project_id' => $this->project_id,
            'flats'      => FlatResource::collection($this->flats)->groupBy(['section', 'floor']),
        ];
    }
}
