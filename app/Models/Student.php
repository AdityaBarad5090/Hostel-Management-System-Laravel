<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = ['name', 'email', 'password', 'phone', 'room_id','photo'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function fee()
    {
        return $this->hasOne(\App\Models\Fee::class);
    }
}
