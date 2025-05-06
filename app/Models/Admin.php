<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin  extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role_id', 'status'];

    // Relationship with Role (Each Admin has one Role)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
public function hasPermission($permission) {
    $hasPermission = $this->role()->whereHas("permissions", function ($query) use ($permission) {
          $query->where("slug", $permission);
    })->exists();
    return $hasPermission;
}

public function isSuperAdmin() {
    return $this->role && $this->role->is_super == 1;
}
    // Admin authentication
    protected $hidden = ['password'];
}
