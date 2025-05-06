<?php

// app/Models/Permission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug'];

    // Permission can belong to many roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
