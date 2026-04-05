<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\Board;
use App\Models\Project\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreBoardRequest;
use App\Http\Requests\Project\UpdateBoardRequest;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Board::class, 'board');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        return $project->boards()->orderBy('position')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request, Project $project)
    {
        $board = $project->boards()->create($request->validated());

        return $board;
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Board $board)
    {
        return $board;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Project $project, Board $board)
    {
        $board->update($request->validated());

        return $board;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Board $board)
    {
        $board->delete();

        return response()->noContent();
    }
}
