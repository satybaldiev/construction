<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Resources\BlockResource;
use App\Http\Resources\ProjectBoardResource;
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

    public function store(ProjectCreateRequest $request)
    {
        $project = Project::create($request->validated());
        return response()->json([
            'message' => __('Project created successfully'),
            'data'    => ProjectResource::make($project)
        ], ResponseAlias::HTTP_CREATED);
    }

    public function show($id)
    {
        $project = Project::query()
            ->with(['blocks' => function ($query) {
                return $query->withCount('flats');
            }, 'files'])
            ->where([
                ['id', '=', $id],
            ])
            ->firstOrFail();
        return new ProjectResource($project);
    }

    public function update(ProjectCreateRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        return response()->json([
            'message' => 'Project updated successfully',
            'data'    => ProjectResource::make($project)
        ]);
    }

    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }

    public function import(Request $request, $project_id)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx'
        ]);
        Project::findOrFail($project_id);
        if ($request->hasFile('file')) {
            Excel::import(new ProjectImport($project_id), $request->file('file')->getRealPath());
            return response()->json([
                'message' => 'File imported successfully'
            ]);
        }
    }

    public function board(Request $request, $project_id)
    {
        $project = Project::query()
            ->with(['blocks.flats', 'files'])
            ->where([
                ['id', '=', $project_id]
            ])
            ->firstOrFail();
        return new ProjectBoardResource($project);
    }
}
