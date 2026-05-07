<?php
namespace App\Http\Controllers;
use App\Models\Fee;
use App\Models\Student;           
use App\Jobs\SendFeeReminderJob;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('student.room')->get();
        return view('fees', compact('fees'));
    }

    public function update(Request $request, $id)
    { 
        Fee::find($id)->update([
            'status' => $request->status,
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Fee::find($id)->delete();
        return redirect()->back();
    }

    public function sendReminder($id)
    {
        $fee = Fee::with('student.room')->find($id);

        if ($fee && $fee->student && $fee->student->email) {
            SendFeeReminderJob::dispatch($fee);
        }

        return redirect()->back()->with('success', 'Reminder sent to ' . $fee->student->name);
    }
    
    // public function sendreminerall(){
    //     $fees = Fee::with('student')->where('status', 'pending')->get();

    //     foreach ($fees as $fee) {
    //         if ($fee->student && $fee->student->email) {
    //             SendFeeReminderJob::dispatch($fee);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Reminders sent to all pending fee students');
    // }
}