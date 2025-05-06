<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['commenter_id', 'commenter_type', 'user_type', 'task_id', 'description'];

    public function commenter()
    {
        return $this->morphTo();
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function isAdminComment()
    {
        return $this->user_type === 'admin';
    }
}