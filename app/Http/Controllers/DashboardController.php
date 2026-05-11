<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Room;
use App\Models\Fee;
use App\Models\Complaint;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $students = Student::count();
        $rooms = Room::count();
        $fees = Fee::count();
        $complaints = Complaint::count();
        $notifications = Notification::where('status', 'unread')->get();

        return view('dashboard', compact('students', 'rooms', 'fees', 'complaints', 'notifications'));
    }
}
