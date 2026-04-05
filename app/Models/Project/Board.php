<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'position',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
