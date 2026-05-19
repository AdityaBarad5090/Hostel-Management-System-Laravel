<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        if ($payload['type'] == 'invoice.payment_succeeded') {

            $customerId = $payload['data']['object']['customer'];

            $student = Student::where(
                'stripe_id',
                $customerId
            )->first();

            if ($student) {
                $student->fees()->update([
                    'status' => 'paid'
                ]);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }
}