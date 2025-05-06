<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];

    public function createdBy() // Make sure this method matches the name used in the controller
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // Many-to-many relationship with User model through the intern_task pivot table
    public function interns()
    {
        return $this->belongsToMany(Intern::class, 'intern_task', 'task_id', 'intern_id');
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
