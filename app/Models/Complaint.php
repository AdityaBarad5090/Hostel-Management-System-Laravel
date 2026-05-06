<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model{
    
    protected $fillable = ['student_id','complaint','status'];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}