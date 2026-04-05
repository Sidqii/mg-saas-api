<?php

namespace App\Policies\Project;

use App\Models\Project\Comment;
use App\Models\Project\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        $workspaceId = $comment->task->board->project->workspace_id;

        return $user->isMemberOf($workspaceId);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Task $task): bool
    {
        $workspaceId = $task->board->project->workspace_id;

        return $user->isMemberOf($workspaceId);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        $workspaceId = $comment->task->board->project->workspace_id;

        $userId = $comment->user_id === $user->id;

        return $userId || $user->roleInWorkspace($workspaceId) === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
