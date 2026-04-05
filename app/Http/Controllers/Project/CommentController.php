<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreCommentRequest;
use App\Http\Requests\Project\UpdateCommentRequest;
use App\Models\Project\Comment;
use App\Models\Project\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        return $task->comments()->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Task $task)
    {
        $comment = $task->comments()->create([
            'content' => $request->validated()['content'],
            'user_id' => $request->user()->id,
        ]);

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, Comment $comment)
    {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Task $task, Comment $comment)
    {
        return $comment->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
