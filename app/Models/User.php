<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Workspace\Workspace;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class)->withPivot(['role', 'joined_at']);
    }

    public function ownedWorkSpaces()
    {
        return $this->hasMany(Workspace::class, 'created_by');
    }

    public function isMemberOf(int $workspaceId)
    {
        return $this->workspaces()->where('workspaces.id', $workspaceId)->exists();
    }

    public function roleInWorkspace(int $workspaceId)
    {
        $workspace = $this->workspaces()->where('workspaces.id', $workspaceId)->first();

        return $workspace?->pivot?->role;
    }

    public function hasPermission(string $permission, int $workspaceId)
    {
        $role = $this->roleInWorkspace($workspaceId);

        $perm = [
            'owner' => [
                'workspace.view',
                'workspace.update',
                'workspace.delete',
            ],
            'member' => [
                'workspace.view',
                'workspace.update',
            ],
        ];

        return in_array($permission, $perm[$role] ?? []);
    }
}
