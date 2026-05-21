<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookHandled;
use App\Models\Student;

class Handlewebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookHandled $event): void
    {
        if ($event->payload['type'] === 'customer.subscription.deleted') {
            $payload = $event->payload;
            $student = Student::where('stripe_id', $payload['data']['object']['customer'])->first();

            if ($student) {
                $student->fees()->update(['status' => 'pending']);
                $student->save();
            }
        }
    }
}
