<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    
    protected $fillable = ['room_number','capacity','occupied','fee'];

    public function students(){
        return $this->hasMany(Student::class);
    }

}