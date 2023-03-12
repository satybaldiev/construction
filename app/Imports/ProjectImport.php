<?php

namespace App\Imports;

use App\Enum\FlatType;
use App\Models\Block;
use App\Models\Flat;
use App\Models\Floor;
use App\Models\Plan;
use App\Models\Section;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProjectImport implements ToCollection, WithStartRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //    const RESIDENTAL = 'residential';
        //    const COMMERCIAL = 'commercial';
        //    const STOREROOM = 'storeroom';
        //    const PARKING = 'parking';
        //    const OTHER = 'other';
        $type = [
            'К' => FlatType::COMMERCIAL,
            'Ж' => FlatType::RESIDENTAL,
            'П' => FlatType::PARKING,
            'Х' => FlatType::STOREROOM,
        ];
        foreach ($collection as $row) {
            if (isset($row[0]) && isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[5]) && isset($row[6])) {
                $block   = Block::updateOrCreate(
                    [
                        'project_id' => $this->project_id,
                        'name'       => $row[0]
                    ]
                );
                $section = Section::updateOrCreate(
                    [
                        'project_id' => $this->project_id,
                        'block_id'   => $block->id,
                        'name'       => $row[1]
                    ],
                );

                $floor = Floor::updateOrCreate(
                    [
                        'project_id' => $this->project_id,
                        'block_id'   => $block->id,
                        'section_id' => $section->id,
                        'name'       => $row[2]
                    ]
                );

                $plan = null;
                if (isset($row[7])) {
                    $plan = Plan::updateOrCreate(
                        [
                            'project_id' => $this->project_id,
                            'name'       => $row[7],
                        ]
                    );
                }
                $flat = Flat::updateOrCreate(
                    [
                        'project_id' => $this->project_id,
                        'block_id'   => $block->id,
                        'section_id' => $section->id,
                        'floor_id' => $floor->id,
                        'name'     => $row[3]
                    ],
                    [
                        'plan_id'    => $plan ? $plan->id : null,
                        'type'       => $type[$row[6]],
                        'area'       => $row[5],
                        'room_count' => $row[4],
                        'notes'      => $row[8] ?? '',
                    ]
                );
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
