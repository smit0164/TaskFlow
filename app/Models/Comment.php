<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'task_id',
        'content',
    ];

    // Relationship to the Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relationship to Admin or Intern based on type
    public function user()
    {
        return $this->morphTo(null, 'type', 'user_id');
    }
}
