<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\BlockResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Imports\ProjectImport;
use App\Models\Block;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BlockController extends Controller
{

    public function store(Request $request, $project_id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $project           = Project::findOrFail($project_id);
        $block             = new Block();
        $block->name       = $request->input('name');
        $block->project_id = $project->id;
        $block->save();
        return response()->json([
            'message' => 'Block created successfully',
            'data'   => BlockResource::make($block)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function update(Request $request, $project_id, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = Block::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();

        $block->name = $request->input('name');
        $block->save();
        return response()->json([
            'message' => 'Block updated successfully',
            'data'   => BlockResource::make($block)
        ]);
    }

    public function destroy(Request $request, $project_id, $id)
    {
        $block = Block::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $block->delete();
        return response()->json([
            'message' => 'Block deleted successfully',
        ]);
    }

    public function board(Request $request, $project_id, $block_id)
    {
        $block = Block::query()
            ->with(['flats', 'files'])
            ->where([
                ['id', '=', $block_id],
                ['project_id', '=', $project_id]
            ])
            ->firstOrFail();
        return new BlockResource($block);
    }
}
