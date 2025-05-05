<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    // Relationship with Role (Each Intern has one Role)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // Intern authentication
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'intern_task', 'intern_id', 'task_id')
                    ->withTimestamps();
    }

    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}

    protected $hidden = ['password'];
}
