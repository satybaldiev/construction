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

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'address'               => 'nullable',
            'start_date'            => 'nullable|date',
            'estimated_finish_date' => 'nullable|date',
            'project_details'       => 'nullable|array',
        ]);
        $project                        = new Project();
        $project->name                  = $request->input('name');
        $project->address               = $request->input('address');
        $project->start_date            = $request->input('start_date');
        $project->estimated_finish_date = $request->input('estimated_finish_date');
        $project->project_details       = $request->input('project_details') ? json_encode($request->input('project_details')) : null;
        $project->save();


        return response()->json([
            'message' => __('Project created successfully'),
            'data'    => ProjectResource::make($project)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function show($project_id,$block_id)
    {
        $block = Block::query()
            ->with(['sections.floors.flats','files'])
            ->where([
                ['id', '=', $block_id],
                ['project_id', '=', $project_id]
            ])
            ->firstOrFail();
        return new BlockResource($block);
    }

    public function update(Request $request, $id)
    {
        $project                        = Project::findOrFail($id);
        $project->name                  = $request->input('name');
        $project->address               = $request->input('address');
        $project->start_date            = $request->input('start_date');
        $project->estimated_finish_date = $request->input('estimated_finish_date');
        $project->project_details       = $request->input('project_details');
        $project->save();
        return response()->json([
            'message' => 'Project updated successfully',
            'project' => ProjectResource::make($project)
        ]);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        //check if project did not have any relations
        if ($project->blocks()->count() == 0 && $project->flats()->count() == 0 && $project->sections()->count() == 0 && $project->floors()->count() == 0) {
            $project->delete();
            return response()->json([
                'message' => 'Project deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Project cannot be deleted because it has relations'
            ]);
        }
    }
}
