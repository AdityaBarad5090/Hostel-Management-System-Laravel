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
            $student = Student::find($request->student_id); 

            $student->createOrGetStripeCustomer();

            $student->newSubscription(
                'hostel_fee',
                'price_1TYNlrDnI4jNVwCfwSGTFPmd'
            )->create($request->payment_method);

            $student->fees()->update(['status' => 'paid']);

            return response()->json(['message' => 'Subscription created successfully!']);
        
    }
}