<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Webhook;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Webhook::create([
            'event_type' => $request->type,
            'payload'    => json_encode($request->all())
        ]);

        $student = Student::where(
            'stripe_id',
            $request->data['object']['customer'] ?? null
        )->first();

        if ($request->type == 'invoice.payment_succeeded') {
            $student?->fees()->update(['status' => 'paid']);
        }

        if ($request->type == 'invoice.payment_failed') {
            $student?->fees()->update(['status' => 'pending']);
        }

        if ($request->type == 'customer.subscription.deleted') {
            $student?->fees()->update(['status' => 'pending']);
        }

        return response()->json(['success' => true]);
    }
}