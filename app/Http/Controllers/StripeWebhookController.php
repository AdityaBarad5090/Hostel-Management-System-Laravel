<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Stripe Webhook:', $request->all());

        return response()->json([
            'success' => true
        ]);
    }
}