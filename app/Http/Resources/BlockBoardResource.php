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
            'block_name' => $this->name,
            'flats'      => FlatResource::collection($this->flats)->groupBy(['section', 'floor']),
        ];
    }
}
