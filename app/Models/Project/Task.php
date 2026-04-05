<?php

namespace App\Models\Project;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'board_id',
        'title',
        'description',
        'assignee_id',
        'due_date',
        'priority',
        'position',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigne_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
