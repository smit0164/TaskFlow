<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'admin_id',
        'intern_id',
        'sender_type',
        'message',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
    protected $appends = ['time'];
    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
