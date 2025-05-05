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

    // Admin authentication
    protected $hidden = ['password'];
}
