<?php

namespace App\Http\Controllers\v1;


use App\Enum\FlatStatus;
use App\Enum\FlatType;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlatCreateRequest;
use App\Http\Resources\BlockResource;
use App\Http\Resources\FlatResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Imports\ProjectImport;
use App\Models\Block;
use App\Models\Flat;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FlatController extends Controller
{

    public function store(FlatCreateRequest $request, $project_id, $block_id)
    {
        $block   = Block::query()->where([
            ['id', '=', $block_id],
            ['project_id', '=', $project_id]
        ])->firstOrFail();
        $flat = $block->flats()->create(array_merge($request->validated(), ['project_id' => $project_id]));
        return response()->json([
            'message' => 'Flat created successfully',
            'data'    => FlatResource::make($flat)
        ], ResponseAlias::HTTP_CREATED);
    }


    public function update(FlatCreateRequest $request, $project_id, $block_id, $id)
    {
        $flat = Flat::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id],
            ['block_id', '=', $block_id]
        ])->firstOrFail();
        $flat->update($request->validated());
        return response()->json([
            'message' => 'Flat updated successfully',
            'data'    => FlatResource::make($flat)
        ], ResponseAlias::HTTP_OK);
    }

    public function destroy(Request $request, $project_id, $block_id, $id)
    {
        Flat::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id],
            ['block_id', '=', $block_id]
        ])->firstOrFail()->delete();
        return response()->json([
            'message' => 'Flat deleted successfully',
        ], ResponseAlias::HTTP_OK);
    }

    public function show($project_id, $block_id, $id)
    {
        $flat = Flat::query()->where([
            ['id', '=', $id],
            ['project_id', '=', $project_id],
            ['block_id', '=', $block_id]
        ])->firstOrFail();
        return response()->json([
            'data' => FlatResource::make($flat)
        ], ResponseAlias::HTTP_OK);
    }
}
