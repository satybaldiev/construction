<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\BlockResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Imports\ProjectImport;
use App\Models\Block;
use App\Models\Project;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SectionController extends Controller
{

    public function store(Request $request, $project_id)
    {
        $request->validate([
            'name' => 'required',
            'block_id' => 'required',
        ]);
        $block           = Block::where([
            ['id', '=', $request->input('block_id')],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $section            = new Section();
        $section->name      = $request->input('name');
        $section->project_id = $project_id;
        $section->block_id  = $block->id;
        $section->save();
        return response()->json([
            'message' => 'Section created successfully',
            'section'   => SectionResource::make($section)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function update(Request $request, $project_id, $id)
    {
        $request->validate([
            'name' => 'required',
            'block_id' => 'required',
        ]);
        $block           = Block::where([
            ['id', '=', $request->input('block_id')],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $section = Section::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $section->name      = $request->input('name');
        $section->block_id  = $block->id;
        $section->save();
        return response()->json([
            'message' => 'Section updated successfully',
            'section'   => SectionResource::make($section)
        ]);

    }

    public function destroy(Request $request, $project_id, $id)
    {
        $section = Section::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $section->delete();
        return response()->json([
            'message' => 'Section deleted successfully',
        ]);
    }
}
