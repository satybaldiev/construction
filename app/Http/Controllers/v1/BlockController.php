<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\BlockCreateRequest;
use App\Http\Resources\BlockBoardResource;
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

    public function store(BlockCreateRequest $request, $project_id)
    {
        $project           = Project::findOrFail($project_id);
        $block = $project->blocks()->create($request->validated());
        return response()->json([
            'message' => 'Block created successfully',
            'data'   => BlockResource::make($block)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function update(BlockCreateRequest $request, $project_id, $id)
    {

        $block = Block::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $block->update($request->validated());
        return response()->json([
            'message' => 'Block updated successfully',
            'data'   => BlockResource::make($block)
        ]);
    }

    public function destroy(Request $request, $project_id, $id)
    {
        Block::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id]
        ])->firstOrFail()->delete();
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
        return new BlockBoardResource($block);
    }
}
