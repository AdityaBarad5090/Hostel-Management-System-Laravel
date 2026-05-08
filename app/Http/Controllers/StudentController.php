<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $rooms = Room::withCount('students')->get();

        $availableRooms = $rooms->filter(function ($room) {
            return $room->students_count < $room->capacity;
        });

        return view('students', [
            'students' => $students,
            'rooms' => $availableRooms
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'room_id' => $request->room_id,
        ]);

        if ($request->room_id) {
            $room = Room::find($request->room_id);
            Fee::create([
                'student_id' => $student->id,
                'amount' => $room->fee,
                'status' => 'pending',
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'room_id' => $request->room_id,
        ];

        if ($request->password) {
            $data['password'] = $request->password;
        }

        $student->update($data);

        if ($request->room_id) {
            $room = Room::find($request->room_id);
            Fee::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'amount' => $room->fee,
                    'status' => Fee::where('student_id', $student->id)->value('status') ?? 'pending'
                ]
            );
        }

        return redirect()->back();
    }
    public function destroy($id)
    {
        Student::find($id)->delete();
        return redirect()->back();
    }

    //Student Side
    public function login(Request $request)
    {
        $student = Student::where('email', $request->email)->first();
        if ($student && $student->password == $request->password) {

            session(['student_id' => $student->id]);
            return redirect('/student/dashboard');
        }
        return back()->with('error', 'Invalid Email or Password');
    }

    public function dashboard()
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        $fees = Fee::where('student_id', $student->id)->latest()->first();
        $room = Room::find($student->room_id);
        $complaints = Complaint::where('student_id', $student->id)->get();

        return view('student-dashboard', compact('student', 'fees', 'room', 'complaints'));
    }

    public function storeComplaint(Request $request)
    {
        Complaint::create([
            'student_id' => session('student_id'),
            'complaint' => $request->complaint,
            'status' => 'Pending'
        ]);

        return redirect()->back();
    }

    public function room()
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        $room = Room::find($student->room_id);

        return view('student-room', compact('room'));
    }

    public function fees()
    {
        $student = Student::with('room')->find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        $fees = Fee::where('student_id', $student->id)->get();

        return view('student-fees', compact('fees', 'student'));
    }

    public function complaint()
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        $room = Room::find($student->room_id);
        $complaints = Complaint::where('student_id', $student->id)->get();

        return view('student-complaint', compact('complaints'));
    }

    public function recipt($id)
    {
        $student = Student::with('room')->find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }
        $fee = Fee::find($id);

        $pdf = Pdf::loadView('student-receipt', compact('student', 'fee'));
        return $pdf->download('receipt.pdf');
    }

    public function payFees($id)
    {
        $student = Student::with('room')->find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        $fee = Fee::find($id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'inr',
                    'product_data' => [
                        'name'        => 'Hostel Fee - ' . $student->name,
                        'description' => 'Room No: ' . ($student->room?->room_number ?? 'N/A'),
                    ],
                    'unit_amount' => $fee->amount * 100, // cents
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => url('/student/fees/success/' . $fee->id),
            'cancel_url'  => url('/student/fees'),
        ]);

        return redirect($session->url);
    }

    public function paySuccess($id)
    {
        $fee = Fee::find($id);

        if ($fee) {
            $fee->update(['status' => 'Paid']);
        }

        return redirect('/student/fees')->with('success', '🎉 Payment Successful! Your fee has been paid.');
    }

    // Add these 2 methods in StudentController.php

    // ─────────────────────────────────────────
    // Show Profile Page
    // ─────────────────────────────────────────
    public function profile()
    {
        $student = Student::with('room')->find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        return view('student-profile', compact('student'));
    }

    // ─────────────────────────────────────────
    // Update Profile
    // ─────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect('/student/login');
        }

        // Validate password match
        if ($request->password && $request->password !== $request->password_confirmation) {
            return redirect()->back()->with('error', 'Passwords do not match!');
        }

        // Update basic info
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Update password if provided
        if ($request->password) {
            $data['password'] = $request->password;
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $student = Student::find(session('student_id'));

        // Check current password
        if ($student->password !== $request->current_password) {
            return redirect()->back()->with('password_error', 'Current password is incorrect!');
        }

        // Check confirmation
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->with('password_error', 'Passwords do not match!');
        }

        $student->password = $request->password;
        $student->save();

        return redirect()->back()->with('success', '✅ Password updated successfully!');
    }
    public function logout()
    {
        session()->forget('student_id');
        return redirect('/');
    }
}
