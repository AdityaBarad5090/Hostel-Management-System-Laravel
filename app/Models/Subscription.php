<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscription;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subscription extends CashierSubscription
{
    public function owner():MorphTo
    {
        return $this->morphTo('owner','owner_type','owner_id');
    }
}