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
    protected $hidden = ['password'];
}
