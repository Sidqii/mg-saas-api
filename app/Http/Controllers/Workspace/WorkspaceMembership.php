<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workspace\Workspace;
use Illuminate\Http\Request;

class WorkspaceMembership extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Workspace::class, 'workspace');
    }

    public function members(Workspace $workspace)
    {
        $members = $workspace->users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->pivot->role,
            ];
        });

        return response()->json($members);
    }

    public function destroy(Workspace $workspace, User $user)
    {
        if (! $workspace->users()->wherePivot('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'User is not a member of this workspace',
            ], 404);
        }

        $workspace->users()->detach($user->id);

        return response()->json([
            'mmessage' => 'Member removed successfully',
        ]);
    }
}
