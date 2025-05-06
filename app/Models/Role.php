<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // app/Models/Role.php

protected $fillable = ['name', 'is_super'];

    

    // Role can have many permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // You may also want to define other relationships like users etc.
}
