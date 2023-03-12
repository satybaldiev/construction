<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
            ->withCount(['blocks', 'flats'])
            ->orderBy($request->input('sort_by', 'id'), $request->input('sort_order', 'desc'))
            ->paginate($request->input('per_page', 20));
        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'address'               => 'nullable',
            'start_date'            => 'nullable|date',
            'estimated_finish_date' => 'nullable|date',
            'project_details'       => 'nullable',
        ]);

        $project = Project::create($request->all());

        return response()->json([
            'message' => __('Project created successfully'),
            'data'    => ProjectResource::make($project)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function show($id)
    {
        $project = Project::find($id);
        return response()->json([
            'message' => 'Project created successfully',
            'project' => ProjectResource::make($project)
        ]);
        return ProjectResource::make($project);


    }

    public function update(Request $request, $id)
    {
        $project                        = Project::find($id);
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
        //check if project did not have relations

    }


}
