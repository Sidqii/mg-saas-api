<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\Project;
use App\Models\Workspace\Workspace;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Workspace $workspace)
    {
        return $workspace->projects()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, Workspace $workspace)
    {
        $project = $workspace->projects()->create(
            array_merge(
                $request->validated(),
                ['created_by' => $request->user()->id]
            )
        );

        return $project;
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace, Project $project)
    {
        return $project;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Workspace $workspace, Project $project)
    {
        $project->update($request->validated());

        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace, Project $project)
    {
        $project->delete();

        return response()->noContent();
    }
}
