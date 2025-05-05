<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // One-to-many relationship with Admin
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

   
}
