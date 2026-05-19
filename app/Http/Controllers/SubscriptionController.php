<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log; 

class SubscriptionController extends Controller
{
    public function index( Student $student)
    {
        return view('subscription', compact('student'));
    }

    public function store(Request $request)
    {
        try {
            $student = Student::findOrFail($request->student_id); 

            $student->createOrGetStripeCustomer();

            $student->newSubscription(
                'hostel_fee',
                'price_1TYNlrDnI4jNVwCfwSGTFPmd'
            )->create($request->payment_method);

            $student->fees()->update(['status' => 'paid']);

            return response()->json(['message' => 'Subscription created successfully!']);

        } catch (\Exception $e) {
            Log::error('Subscription error: ' . $e->getMessage()); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}