<?php

namespace App\Models;

use Laravel\Cashier\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Concerns\InteractsWithStripe;

class Student extends Authenticatable
{
    use Billable;
    use InteractsWithStripe;

    protected $fillable = ['name', 'email', 'password', 'phone', 'room_id', 'photo'];

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

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'owner')->orderBy('created_at', 'desc');
    }
}
